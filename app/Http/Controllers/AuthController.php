<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /** Halaman Login */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    /** Halaman Register */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.register');
    }

    /** Proses Register Mahasiswa */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nim' => 'nullable|unique:users,nim',
            'prodi' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'ipk' => 'required|numeric|min:0|max:4',
            'fakultas' => 'nullable|string|max:100',
        ]);

        // Generate verification token
        $verificationToken = \Str::random(64);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nim' => $validated['nim'] ?? null,
            'prodi' => $validated['prodi'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'ipk' => $validated['ipk'],
            'role' => 'mahasiswa',
            'verification_token' => $verificationToken,
        ]);

        // Send verification email
        $this->sendVerificationEmail($user, $verificationToken);

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Registrasi berhasil. Silakan cek email Anda untuk verifikasi.');
    }

    /**
     * Send verification email
     */
    private function sendVerificationEmail($user, $token)
    {
        try {
            $verificationUrl = url('/verify-email/' . $token);

            \Mail::send('emails.verify_email', [
                'user' => $user,
                'verificationUrl' => $verificationUrl
            ], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Verifikasi Email Anda - Sistem Wisuda');
            });

            \Log::info('Verification email sent to: ' . $user->email);
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
        }
    }

    /** Proses Login */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt login only for 'mahasiswa' role
        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'mahasiswa';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau akun bukan mahasiswa.',
        ])->onlyInput('email');
    }

    /** Logout User */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Berhasil logout.');
    }

    /** Logout Admin */
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form')
            ->with('success', 'Admin berhasil logout.');
    }

    /** Halaman Login Admin */
    public function showAdminLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.admin-login');
    }

    /** Proses Login Admin */
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt login only for 'admin' role
        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'admin';

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau akun bukan admin.',
        ])->onlyInput('email');
    }


    /** Redirect Sesuai Role */
    private function redirectByRole(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'mahasiswa') {
            return redirect()->route('dashboard');
        }

        return redirect('/')
            ->with('info', 'Role tidak dikenali.');
    }

    /**
     * Verify email with token
     */
    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Token verifikasi tidak valid.');
        }

        if ($user->email_verified_at) {
            return redirect()->route('login')
                ->with('info', 'Email sudah terverifikasi sebelumnya.');
        }

        $user->update([
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);

        return redirect()->route('login')
            ->with('success', 'Email berhasil diverifikasi! Silakan login.');
    }

    /**
     * Resend verification email
     */
    public function resendVerification(Request $request)
    {
        $user = Auth::user();

        if ($user->email_verified_at) {
            return back()->with('info', 'Email Anda sudah terverifikasi.');
        }

        // Generate new token
        $verificationToken = \Str::random(64);
        $user->update(['verification_token' => $verificationToken]);

        // Send email
        $this->sendVerificationEmail($user, $verificationToken);

        return back()->with('success', 'Email verifikasi telah dikirim ulang. Silakan cek inbox Anda.');
    }
}
