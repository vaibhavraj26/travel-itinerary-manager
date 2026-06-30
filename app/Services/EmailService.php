<?php

namespace App\Services;

use App\Models\Trip;
use App\Models\TripInvitation;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class EmailService
{
    public function sendWelcome(User $user): void
    {
        $this->sendNotification(
            $user->email,
            'Welcome back to ' . config('app.name'),
            'Welcome back, ' . $user->name,
            'You have successfully signed in. Your trips, budgets, and invitations are ready whenever you are.',
            'Open Dashboard',
            route('home')
        );
    }

    public function sendPasswordResetOtp(User $user, string $otp): void
    {
        $this->sendNotification(
            $user->email,
            'Your password reset code',
            'Use this code to reset your password',
            'Enter the 6-digit code below in the password reset form. It expires in 10 minutes and can be used once.',
            null,
            null,
            $otp
        );
    }

    public function sendPasswordResetSuccess(User $user): void
    {
        $this->sendNotification(
            $user->email,
            'Your password has been reset successfully',
            'Password updated successfully',
            'If this was not you, please contact support immediately at <a href="mailto:5860vaibhav@gmail.com" style="color: #f97316; text-decoration: underline;">support@triptogether.com</a>.',
            'Go to Sign In', 
            route('login')
        );
    }

    public function sendPlanUpgraded(User $user): void
    {
        $this->sendNotification(
            $user->email,
            'Your Explorer Plus upgrade is active',
            'Explorer Plus is now active',
            'Your plan upgrade went through successfully. You can now use the premium trip tools, AI planner, and collaboration features.',
            'Go to Home',
            route('home')
        );
    }

    public function sendTripInvitation(Trip $trip, string $email, ?User $inviter, string $role, bool $registered): void
    {
        $inviterName = $inviter?->name ?? 'A trip member';
        $actionLabel = $registered ? 'Open Dashboard' : 'Register and Join';
        $actionUrl = $registered ? route('home') : route('register', ['email' => $email]);

        $this->sendNotification(
            $email,
            $inviterName . ' invited you to ' . $trip->title,
            'You have a trip invitation',
            $inviterName . ' invited you to join ' . $trip->title . ' in ' . $trip->destination . ' as a ' . strtoupper($role) . '. ' . ($registered ? 'Log in to accept the invitation from your dashboard.' : 'Create your account with the same email address to join automatically.'),
            $actionLabel,
            $actionUrl
        );
    }

    public function notifyTripMembersJoined(Trip $trip, User $joinedUser): void
    {
        $trip->loadMissing(['user', 'sharedUsers']);

        $recipientEmails = collect([$trip->user?->email])
            ->merge(
                $trip->sharedUsers
                    ->filter(fn ($member) => (bool) ($member->pivot->is_accepted ?? false))
                    ->pluck('email')
            )
            ->filter()
            ->map(fn ($email) => strtolower($email))
            ->unique()
            ->reject(fn ($email) => $email === strtolower($joinedUser->email));

        foreach ($recipientEmails as $recipientEmail) {
            $this->sendNotification(
                $recipientEmail,
                $joinedUser->name . ' joined ' . $trip->title,
                'A member joined the trip',
                $joinedUser->name . ' has accepted the trip invitation and joined ' . $trip->title . '. Everyone can now collaborate together.',
                'View Trip',
                route('trips.show', $trip)
            );
        }
    }

    public function claimGuestInvitations(User $user): void
    {
        $invitations = TripInvitation::with(['trip.user', 'trip.sharedUsers'])
            ->whereRaw('LOWER(email) = ?', [strtolower($user->email)])
            ->get();

        foreach ($invitations as $invitation) {
            $trip = $invitation->trip;

            if (!$trip) {
                $invitation->delete();
                continue;
            }

            $trip->sharedUsers()->syncWithoutDetaching([
                $user->id => [
                    'role' => $invitation->role,
                    'is_accepted' => false,
                    'invited_by' => $invitation->invited_by,
                ],
            ]);

            $trip->sharedUsers()->updateExistingPivot($user->id, [
                'role' => $invitation->role,
                'is_accepted' => false,
                'invited_by' => $invitation->invited_by,
            ]);

            $invitation->delete();
        }
    }

    private function sendNotification(
        string $email,
        string $subject,
        string $heading,
        string $body,
        ?string $actionLabel = null,
        ?string $actionUrl = null,
        ?string $code = null,
    ): void {
        $apiKey = config('services.brevo.key');
        $senderEmail = config('services.brevo.sender_email');
        $senderName = config('services.brevo.sender_name', config('app.name'));

        if (!is_string($apiKey) || $apiKey === '') {
            \Log::warning('BREVO_API_KEY is not configured. Skipping email notification.');
            return;
        }

        if (!is_string($senderEmail) || $senderEmail === '') {
            \Log::warning('BREVO_SENDER_EMAIL is not configured. Skipping email notification.');
            return;
        }

        $html = view('emails.notification', [
            'subjectLine' => $subject,
            'heading' => $heading,
            'body' => $body,
            'actionLabel' => $actionLabel,
            'actionUrl' => $actionUrl,
            'code' => $code,
        ])->render();

        $text = $heading . "\n\n" . strip_tags($body);

        if ($code) {
            $text .= "\n\nOTP Code: " . $code;
        }

        if ($actionLabel && $actionUrl) {
            $text .= "\n\n" . $actionLabel . ': ' . $actionUrl;
        }

        $cleanEmail = trim(strtolower($email));

        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'api-key' => $apiKey,
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => [
                    'email' => $senderEmail,
                    'name' => $senderName,
                ],
                'to' => [
                    ['email' => $cleanEmail],
                ],
                'subject' => $subject,
                'htmlContent' => $html,
                'textContent' => $text,
            ]);

            if ($response->failed()) {
                \Log::error('Brevo API error: ' . $response->status() . ' ' . $response->body());
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send email via Brevo: ' . $e->getMessage());
        }
    }
}
