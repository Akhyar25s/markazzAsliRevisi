<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    /**
     * Proses login user
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt(['nama' => $credentials['nama'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect('/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'nama' => 'Username atau password salah.',
        ])->onlyInput('nama');
    }

    /**
     * Tampilkan halaman registrasi
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.register');
    }

    /**
     * Proses registrasi user baru - HANYA VALIDASI, JANGAN BUAT AKUN
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        // HANYA VALIDASI FORM - JANGAN BUAT USER YET
        // Return form data untuk lanjut ke face scan
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data valid! Lanjut ke scan wajah.',
                'form_data' => $validated,
            ]);
        }

        return back()->with('form_data', $validated);
    }

    /**
     * Proses capture & simpan face data saat registrasi
     */
    public function storeFaceData(Request $request)
    {
        // VALIDATE COMPLETE DATA
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|min:10|max:15|unique:users',
            'alamat' => 'required|string|max:500',
            'password' => 'required|string|min:6',
            'face_data' => 'required|string', // Array face descriptors di-JSON stringify
        ]);

        try {
            // BUAT USER + SIMPAN FACE_DATA DALAM SATU TRANSAKSI
            $user = User::create([
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'password' => Hash::make($request->password),
                'role' => 'anggota_jamaah',
                'face_data' => $request->face_data,
            ]);

            \Log::info('User registered with face data: ' . $user->id);

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Wajah tersimpan. Silakan login.',
                'redirect' => '/login',
            ]);
        } catch (\Exception $e) {
            \Log::error('Face data storage error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan akun: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil!');
    }

    /**
     * Dashboard - tampilkan menu halaqah
     */
    public function dashboard()
    {
        $user = Auth::user();

        return view('dashboard', [
            'user' => $user,
        ]);
    }
}
