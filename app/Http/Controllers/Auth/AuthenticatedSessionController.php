<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan login.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Coba otentikasi pengguna
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika gagal, kembalikan ke form login dengan pesan error
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // 3. Regenerasi session untuk keamanan
        $request->session()->regenerate();

        $user = Auth::user();

        // 4. Redirect berdasarkan role
        if ($user->role === 'kepala_sekolah') {
            return redirect()->intended(route('dashboard.kepala-sekolah'));
        }

        return redirect()->intended(route('dashboard.guru'));
    }

    /**
     * Menangani proses logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}