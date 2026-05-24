<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
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

    Route::get('/home', function () {
        return view('dashboard.index');
    })->name('home');

    Route::get('/ai-planner', function () {
        return view('ai-planner');
    })->name('ai.planner');
    Route::post('/ai-planner', [TripController::class, 'storeAiPlan'])->name('ai.planner.store');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Trips Management
    Route::get('/trips', [TripController::class, 'index'])->name('trips.index');
    Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
    Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');
    Route::get('/trips/{trip}/edit', [TripController::class, 'edit'])->name('trips.edit');
    Route::put('/trips/{trip}', [TripController::class, 'update'])->name('trips.update');
    Route::put('/trips/{trip}/quick-notes', [TripController::class, 'updateQuickNotes'])->name('trips.quicknotes.update');
    Route::delete('/trips/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');

    // Trip Activities
    Route::post('/trips/{trip}/activities', [TripController::class, 'storeActivity'])->name('trips.activities.store');
    Route::put('/trips/{trip}/activities/{activity}', [TripController::class, 'updateActivity'])->name('trips.activities.update');
    Route::put('/trips/{trip}/activities/{activity}/complete', [TripController::class, 'completeActivity'])->name('trips.activities.complete');
    Route::put('/trips/{trip}/activities/{activity}/undo-complete', [TripController::class, 'undoCompleteActivity'])->name('trips.activities.undo-complete');
    Route::delete('/trips/{trip}/activities/{activity}', [TripController::class, 'deleteActivity'])->name('trips.activities.delete');
    
    // Trip Expenses
    Route::post('/trips/{trip}/expenses', [TripController::class, 'storeExpense'])->name('trips.expenses.store');
    Route::put('/trips/{trip}/expenses/{expense}', [TripController::class, 'updateExpense'])->name('trips.expenses.update');
    Route::delete('/trips/{trip}/expenses/{expense}', [TripController::class, 'deleteExpense'])->name('trips.expenses.delete');
    Route::put('/trips/{trip}/budget', [TripController::class, 'updateBudget'])->name('trips.budget.update');
    
    // Trip Members (Sharing)
    Route::post('/trips/{trip}/members', [TripController::class, 'addMember'])->name('trips.members.store');
    Route::delete('/trips/{trip}/members/{user}', [TripController::class, 'removeMember'])->name('trips.members.destroy');
    Route::post('/trips/{trip}/members/accept', [TripController::class, 'acceptInvitation'])->name('trips.members.accept');
    Route::post('/trips/{trip}/members/decline', [TripController::class, 'declineInvitation'])->name('trips.members.decline');
    Route::delete('/trips/{trip}/invitations/{invitation}', [TripController::class, 'cancelInvitation'])->name('trips.invitations.destroy');

    Route::get('/destinations', function () {
        return view('dashboard.index');
    })->name('destinations.index');

    Route::get('/checkout', function () {
        if (Auth::user()->plan === 'plus') {
            return redirect()->route('home')->with('info', 'You are already on the Explorer Plus plan!');
        }
        return view('checkout');
    })->name('checkout');

    Route::post('/checkout', [AuthController::class, 'processCheckout'])->name('checkout.submit');
});
