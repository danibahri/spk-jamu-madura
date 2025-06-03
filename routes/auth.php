<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->remember)) {
        $request->session()->regenerate();
        alert()->success('Selamat Datang!', 'Anda berhasil masuk ke sistem SPK Jamu Madura');
        return redirect()->intended('/');
    }

    alert()->error('Login Gagal', 'Email atau password yang Anda masukkan salah');
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
})->name('login.store');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    Auth::login($user);

    alert()->success('Pendaftaran Berhasil!', 'Selamat datang ' . $user->name . '! Akun Anda telah berhasil dibuat.');
    return redirect('/');
})->name('register.store');

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    alert()->success('Logout Berhasil', 'Terima kasih telah menggunakan SPK Jamu Madura. Sampai jumpa!');
    return redirect('/');
})->name('logout');
