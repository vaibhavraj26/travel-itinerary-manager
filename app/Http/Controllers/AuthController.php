<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'email.unique' => 'User already exists, <a href="#" onclick="switchTab(\'login\'); return false;" class="underline font-bold hover:text-red-700">try sign in</a>.',
        ]);

        $plan = $request->input('plan');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'plan' => 'free',
        ]);

        // Login the user after registration and remember them for 30 days
        Auth::login($user, true);

        if (!$plan) {
            $request->session()->flash('onboarding', true);
        }

        return $this->redirectBasedOnIntent($request);
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // The second parameter "true" tells Laravel to remember the user
        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();

            if ($request->filled('plan')) {
                return $this->redirectBasedOnIntent($request);
            }

            return redirect()->intended(route('trips.index'));
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Process checkout and save plan.
     */
    public function processCheckout(Request $request)
    {
        $user = Auth::user();

        if ($user->plan === 'plus') {
            return redirect()->route('trips.index')->with('info', 'You are already on the Explorer Plus plan!');
        }

        $validated = $request->validate([
            'payment_type' => ['required', 'string', 'in:card,trial'],
        ]);

        $paymentType = $validated['payment_type'];
        $paymentVerified = $request->session()->boolean('checkout.payment_verified');
        $trialCreated = $request->session()->boolean('checkout.trial_created');

        if (
            ($paymentType === 'card' && !$paymentVerified) ||
            ($paymentType === 'trial' && !$trialCreated)
        ) {
            return redirect()->route('trips.index')->withErrors([
                'checkout' => 'We could not verify your checkout. Please complete payment or trial activation before upgrading.',
            ]);
        }

        $user->plan = 'plus';
        $user->save();

        $request->session()->forget([
            'checkout.payment_verified',
            'checkout.trial_created',
        ]);

        return redirect()->route('trips.index')->with('success', 'Welcome to Explorer Plus! Your upgrade is now active.');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }

    /**
     * Delete the user's account.
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect()->route('landing');
    }

    /**
     * Redirect user based on their selected plan intent.
     */
    private function redirectBasedOnIntent(Request $request)
    {
        $plan = $request->input('plan');

        if ($plan === 'free') {
            return redirect()->route('trips.index');
        } elseif ($plan === 'plus') {
            return redirect()->route('checkout');
        }

        return redirect()->route('pricing');
    }
}
