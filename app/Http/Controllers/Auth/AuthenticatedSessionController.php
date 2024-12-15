<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Coba login sebagai admin
        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            return response()->json([
                'success' => true,
                'redirect' => url('/admin/dashboard')
            ]);
        }
    
        // Ambil user berdasarkan email
        $user = \App\Models\User::where('email', $request->email)->first();
    
        // Cek apakah user ada dan statusnya aktif
        if ($user && $user->status === 'aktif') {
            // Coba login sebagai user biasa
            if (Auth::guard('web')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
                $request->session()->regenerate();
                return response()->json([
                    'success' => true,
                    'redirect' => url('/home')
                ]);
            }
        }
    
        // Jika login gagal
        return response()->json([
            'success' => false,
            'message' => $user && $user->status !== 'aktif'
                ? 'Akun Anda sedang diblokir! silahkan hubungi admin.'
                : 'Akun tidak ditemukan.'
        ], 401);
    }
    

    public function destroy(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::guard('web')->logout();
        }
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redirect to home after logout
        return redirect('/');
    }
    
}
