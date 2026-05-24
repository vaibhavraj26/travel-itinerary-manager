<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ProfileController;
use App\Models\Expense;
use App\Models\ItineraryActivity;
use Carbon\Carbon;
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
    Route::post('/forgot-password/otp', [AuthController::class, 'requestPasswordResetOtp'])->name('password.otp.request');
    Route::post('/forgot-password/otp/verify', [AuthController::class, 'verifyPasswordResetOtp'])->name('password.otp.verify');
    Route::post('/forgot-password/reset', [AuthController::class, 'resetPasswordWithOtp'])->name('password.otp.reset');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('/account', [AuthController::class, 'deleteAccount'])->name('account.delete');

    $dashboardData = function () {
        $user = Auth::user();
        $today = Carbon::today();

        $trips = $user->trips()->latest()->get();

        $classifyTrip = function ($trip) use ($today) {
            if ($trip->status === 'cancelled') {
                return 'cancelled';
            }

            $start = Carbon::parse($trip->start_date)->startOfDay();
            $end = Carbon::parse($trip->end_date)->endOfDay();

            if ($today->lt($start)) {
                return 'upcoming';
            }

            if ($today->between($start, $end)) {
                return 'active';
            }

            return 'completed';
        };

        $tripSummaries = $trips->map(function ($trip) use ($classifyTrip) {
            $trip->computed_status = $classifyTrip($trip);
            return $trip;
        });

        $upcomingTripsCount = $tripSummaries->where('computed_status', 'upcoming')->count();
        $activeItinerariesCount = $tripSummaries->where('computed_status', 'active')->count();
        $totalBudget = (float) $tripSummaries->sum(fn ($trip) => $trip->budget ?? 0);
        $nextTrip = $tripSummaries
            ->where('computed_status', 'upcoming')
            ->sortBy('start_date')
            ->first();

        $tripIds = $trips->pluck('id');

        $tripCreatedEvents = $trips->sortByDesc('created_at')->take(3)->map(function ($trip) {
            return [
                'kind' => 'trip',
                'title' => $trip->title,
                'description' => 'Trip planned for ' . $trip->destination,
                'time_label' => $trip->created_at?->diffForHumans() ?? 'Just now',
                'occurred_at' => $trip->created_at,
            ];
        });

        $activityEvents = $tripIds->isEmpty()
            ? collect()
            : ItineraryActivity::query()
                ->whereIn('trip_id', $tripIds)
                ->with('trip')
                ->latest('created_at')
                ->take(4)
                ->get()
                ->map(function ($activity) {
                    return [
                        'kind' => 'activity',
                        'title' => $activity->title,
                        'description' => 'Added to ' . ($activity->trip?->title ?? 'your trip'),
                        'time_label' => $activity->created_at?->diffForHumans() ?? 'Just now',
                        'occurred_at' => $activity->created_at,
                    ];
                });

        $expenseEvents = $tripIds->isEmpty()
            ? collect()
            : Expense::query()
                ->whereIn('trip_id', $tripIds)
                ->with('trip')
                ->latest('created_at')
                ->take(4)
                ->get()
                ->map(function ($expense) {
                    return [
                        'kind' => $expense->type === 'budget' ? 'budget' : 'expense',
                        'title' => $expense->title,
                        'description' => strtoupper($expense->type) . ' recorded for ' . ($expense->trip?->title ?? 'your trip'),
                        'time_label' => $expense->created_at?->diffForHumans() ?? 'Just now',
                        'occurred_at' => $expense->created_at,
                    ];
                });

        $recentEvents = $tripCreatedEvents
            ->merge($activityEvents)
            ->merge($expenseEvents)
            ->sortByDesc('occurred_at')
            ->take(4)
            ->values();

        return compact(
            'tripSummaries',
            'upcomingTripsCount',
            'activeItinerariesCount',
            'totalBudget',
            'nextTrip',
            'recentEvents'
        );
    };

    Route::get('/home', function () use ($dashboardData) {
        return view('dashboard.index', $dashboardData());
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
    Route::get('/trips/{trip}/members', function (\App\Models\Trip $trip) {
        return redirect()->route('trips.show', $trip);
    });
    Route::post('/trips/{trip}/members', [TripController::class, 'addMember'])->name('trips.members.store');
    Route::delete('/trips/{trip}/members/{user}', [TripController::class, 'removeMember'])->name('trips.members.destroy');
    Route::post('/trips/{trip}/members/accept', [TripController::class, 'acceptInvitation'])->name('trips.members.accept');
    Route::post('/trips/{trip}/members/decline', [TripController::class, 'declineInvitation'])->name('trips.members.decline');
    Route::delete('/trips/{trip}/invitations/{invitation}', [TripController::class, 'cancelInvitation'])->name('trips.invitations.destroy');

    Route::get('/destinations', function () use ($dashboardData) {
        return view('dashboard.index', $dashboardData());
    })->name('destinations.index');

    Route::get('/checkout', function () {
        if (Auth::user()->plan === 'plus') {
            return redirect()->route('home')->with('info', 'You are already on the Explorer Plus plan!');
        }
        return view('checkout');
    })->name('checkout');

    Route::post('/checkout', [AuthController::class, 'processCheckout'])->name('checkout.submit');
});
