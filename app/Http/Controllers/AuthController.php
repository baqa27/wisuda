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
            'identity' => 'required|string',
            'password' => 'required|string',
        ]);

        $identity = $request->identity;
        $field = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        // Cek credential: email/nim, password, dan role=mahasiswa
        if (
            Auth::attempt([
                $field => $identity,
                'password' => $request->password,
                'role' => 'mahasiswa'
            ])
        ) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        // Cek jika admin mencoba login disini (opsional, tapi bagus untuk UX)
        // Jika input adalah email, kita bisa cek user admin
        if ($field === 'email') {
            $user = User::where('email', $identity)->first();
            if ($user && Hash::check($request->password, $user->password) && $user->isAdmin()) {
                return back()->withErrors([
                    'identity' => 'Admin harap login melalui halaman /admin',
                ])->onlyInput('identity');
            }
        }

        return back()->withErrors([
            'identity' => 'Email/NIM atau password salah.',
        ])->onlyInput('identity');
    }

    /** Logout */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Berhasil logout.');
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

    // ==========================
    // 👑 ADMIN AUTH
    // ==========================

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
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Coba login sebagai admin menggunakan guard 'admin'
        \Log::info('Admin Login Attempt', ['email' => $request->email]);
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin'])) {
            $request->session()->regenerate();

            \Log::info('Admin Login Success. Session Regenerated.', [
                'user_id' => Auth::guard('admin')->id(),
                'check' => Auth::guard('admin')->check()
            ]);

            return redirect()->route('admin.dashboard');
        } else {
            \Log::warning('Admin Login Failed via Guard Attempt');
        }

        // Cek apakah user ada di database
        $user = User::where('email', $request->email)->first();

        // Jika user ada, password benar, TAPI role bukan admin
        if ($user && Hash::check($request->password, $user->password) && !$user->isAdmin()) {
            return back()->withErrors([
                'email' => 'Akun ini terdaftar sebagai Mahasiswa, bukan Admin.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /** Logout Admin */
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form')
            ->with('success', 'Berhasil logout (Admin).');
    }
}
