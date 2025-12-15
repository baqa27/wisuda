<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nim'      => 'nullable|unique:users,nim',
            'prodi'    => 'nullable|string|max:100',
            'no_hp'    => 'nullable|string|max:15',
            'ipk'      => 'required|numeric|min:0|max:4',
            'fakultas' => 'nullable|string|max:100',
            'semester' => 'required|integer|min:7',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nim'      => $validated['nim'] ?? null,
            'prodi'    => $validated['prodi'] ?? null,
            'no_hp'    => $validated['no_hp'] ?? null,
            'ipk'      => $validated['ipk'],
            'semester' => $validated['semester'],
            'role'     => 'mahasiswa',
        ]);

        // event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Registrasi berhasil. Selamat datang.');
    }

    /** Proses Login */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
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
        $request->session()->invalidate(); // Invalidate session for security
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
}
