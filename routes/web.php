<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('trips.index');
    }
    return view('landing');
})->name('landing');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('register');
    })->name('register');

    Route::get('/login', function () {
        return view('register');
    })->name('login');

    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('/account', [AuthController::class, 'deleteAccount'])->name('account.delete');

    Route::get('/trips', function () {
        return view('dashboard');
    })->name('trips.index');
    
    Route::get('/destinations', function () {
        return view('dashboard');
    })->name('destinations.index');

    Route::get('/checkout', function () {
        if (Auth::user()->plan === 'plus') {
            return redirect()->route('trips.index')->with('info', 'You are already on the Explorer Plus plan!');
        }
        return view('checkout');
    })->name('checkout');

    Route::post('/checkout', [AuthController::class, 'processCheckout'])->name('checkout.submit');
});
