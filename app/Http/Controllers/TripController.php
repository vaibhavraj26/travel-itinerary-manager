<?php

namespace App\Http\Controllers;

use App\Models\TripInvitation;
use App\Services\EmailService;
use Illuminate\Http\Request;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Client\ConnectionException;

class TripController extends Controller
{
    public function __construct(private EmailService $emailService)
    {
    }

    /**
     * Display a listing of the trips.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $query = Trip::query()
            ->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhereHas('sharedUsers', function ($sq) use ($userId) {
                      $sq->where('user_id', $userId)
                         ->where('trip_user.is_accepted', true);
                  });
            })
            ->with(['user', 'sharedUsers', 'invitations']);

        // Track whether the user has any trips at all (before filters)
        $hasAnyTrips = Trip::query()
            ->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhereHas('sharedUsers', function ($sq) use ($userId) {
                      $sq->where('user_id', $userId)
                         ->where('trip_user.is_accepted', true);
                  });
            })
            ->count() > 0;

        if ($request->filled('search')) {
            $q = $request->input('search');
            $query->where(function ($sq) use ($q) {
                $sq->where('title', 'like', "%{$q}%")
                   ->orWhere('destination', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        $sort = $request->input('sort', 'newest');
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'date') {
            $query->orderBy('start_date', 'asc');
        } else {
            $query->latest();
        }

            $trips = $query->get();

            if ($request->ajax()) {
                $html = view('trips._grid', compact('trips', 'hasAnyTrips'))->render();
                return response()->json(['html' => $html]);
            }

            return view('trips.index', compact('trips', 'hasAnyTrips'));
    }

    /**
     * Show the form for creating a new trip.
     */
    public function create()
    {
        return view('trips.create');
    }

    /**
     * Store a newly created trip in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:upcoming,active,completed,cancelled',
            'image_url' => 'nullable|url',
            'budget' => 'nullable|numeric|min:0',
        ]);

        Auth::user()->trips()->create($validated);

        return redirect()->route('trips.index')->with('success', 'Adventure planned successfully!');
    }

    /**
     * Store an AI-generated plan as a new trip with activities.
     */
    public function storeAiPlan(Request $request)
    {
        if (Auth::user()->plan !== 'plus') {
            return redirect()->route('pricing')->with('error', 'Upgrade to Explorer Plus to use AI Planner.');
        }

        $validated = $request->validate([
            'destination' => 'required|string|max:255',
            'days' => 'required|integer|min:1|max:30',
            'start_date' => 'required|date',
            'style' => 'required|in:Balanced,Relaxed,Adventure,Culture,Foodie',
            'budget' => 'required|in:Budget,Comfort,Luxury',
            'interests' => 'nullable|array',
            'interests.*' => 'in:Nature,Museums,Nightlife,Shopping,Local Food,Wellness',
        ]);

        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = (clone $startDate)->addDays($validated['days'] - 1);
        $interests = $validated['interests'] ?? [];

        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-3-flash-preview');

        if (empty($apiKey)) {
            return redirect()->route('ai.planner')->withErrors(['Gemini API key is not configured.']);
        }

        $interestText = count($interests) ? implode(', ', $interests) : 'No specific interests provided';
        $prompt = "You are a travel planner. Generate a detailed itinerary as JSON only.\n"
            . "Destination: {$validated['destination']}\n"
            . "Start date: {$startDate->toDateString()}\n"
            . "Days: {$validated['days']}\n"
            . "Style: {$validated['style']}\n"
            . "Budget: {$validated['budget']}\n"
            . "Interests: {$interestText}\n\n"
            . "Return JSON in this exact shape (JSON only, no commentary):\n"
            . "{\"image_url\":\"https://example.com/photo.jpg\",\"days\":[{\"day\":1,\"activities\":[{\"title\":\"...\",\"location\":\"...\",\"type\":\"activity\",\"notes\":\"...\"}]}]}\n"
            . "Set the top-level \"image_url\" to a single representative image URL for the trip (prefer a royalty-free Unsplash or Pexels URL)."
            . " Each day must have 2-4 activities with specific locations. Use concise titles.";

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(30)
                ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $prompt],
                            ],
                        ],
                    ],
                ]);
        } catch (ConnectionException $e) {
            return redirect()->route('ai.planner')->withErrors([
                'AI service could not be reached. Please check your internet connection and try again.',
            ]);
        }

        if (!$response->ok()) {
            return redirect()->route('ai.planner')->withErrors(['AI service is unavailable. Try again later.']);
        }

        $text = data_get($response->json(), 'candidates.0.content.parts.0.text');
        if (!$text) {
            return redirect()->route('ai.planner')->withErrors(['AI response was empty. Try again.']);
        }

        $jsonStart = strpos($text, '{');
        $jsonEnd = strrpos($text, '}');
        $jsonPayload = ($jsonStart !== false && $jsonEnd !== false) ? substr($text, $jsonStart, $jsonEnd - $jsonStart + 1) : null;
        $plan = $jsonPayload ? json_decode($jsonPayload, true) : null;

        if (!is_array($plan) || empty($plan['days']) || !is_array($plan['days'])) {
            return redirect()->route('ai.planner')->withErrors(['AI response format was invalid. Try again.']);
        }

        $titleSuffixes = [
            'Balanced' => 'Balanced Escape',
            'Relaxed' => 'Slow Escape',
            'Adventure' => 'Adventure Trail',
            'Culture' => 'Culture Trail',
            'Foodie' => 'Foodie Trail',
        ];
        $interestTag = count($interests) ? $interests[0] : null;
        $title = $validated['destination'] . ' ' . ($titleSuffixes[$validated['style']] ?? 'Getaway');
        if ($interestTag) {
            $title .= ' • ' . $interestTag;
        }

        $imageUrl = null;
        if (!empty($plan['image_url']) && filter_var($plan['image_url'], FILTER_VALIDATE_URL)) {
            $imageUrl = $plan['image_url'];
        }

        $trip = Auth::user()->trips()->create([
            'title' => $title,
            'destination' => $validated['destination'],
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'description' => 'Style: ' . $validated['style'] . ' | Budget: ' . $validated['budget'] . (count($interests) ? ' | Interests: ' . implode(', ', $interests) : ''),
            'status' => 'upcoming',
            'image_url' => $imageUrl,
        ]);

        foreach ($plan['days'] as $dayIndex => $dayPlan) {
            $dayNumber = isset($dayPlan['day']) ? (int) $dayPlan['day'] : ($dayIndex + 1);
            $activityDate = (clone $startDate)->addDays($dayNumber - 1)->toDateString();
            $activities = $dayPlan['activities'] ?? [];

            foreach ($activities as $activity) {
                $title = isset($activity['title']) ? (string) $activity['title'] : 'Day ' . $dayNumber . ' Activity';
                $location = isset($activity['location']) ? (string) $activity['location'] : $validated['destination'];
                $type = isset($activity['type']) ? (string) $activity['type'] : 'activity';
                $notes = isset($activity['notes']) ? (string) $activity['notes'] : null;

                $trip->activities()->create([
                    'date' => $activityDate,
                    'title' => $title,
                    'type' => $type,
                    'location' => $location,
                    'notes' => $notes,
                ]);
            }
        }

        return redirect()->route('trips.show', $trip)->with('success', 'AI itinerary created successfully!');
    }

    /**
     * Display the specified trip.
     */
    public function show(Trip $trip)
    {
        $this->authorizeTrip($trip);
        $trip->load(['activities', 'sharedUsers', 'invitations']);
        // Auto-update trip status based on dates unless it's explicitly cancelled
        try {
            $today = \Carbon\Carbon::today();
            $start = \Carbon\Carbon::parse($trip->start_date)->startOfDay();
            $end = \Carbon\Carbon::parse($trip->end_date)->endOfDay();

            $computedStatus = $today->lt($start) ? 'upcoming' : ($today->between($start, $end) ? 'active' : 'completed');

            if ($trip->status !== 'cancelled' && $trip->status !== $computedStatus) {
                $trip->update(['status' => $computedStatus]);
                $trip->refresh();
            }
        } catch (\Exception $e) {
            // If dates are invalid or parsing fails, don't block the view — keep existing status
        }
        
        // Load expenses including soft-deleted ones to show deletion history
        $expenses = $trip->expenses()->withTrashed()->with(['user', 'editedBy', 'deletedBy'])->get();
        $trip->setRelation('expenses', $expenses);
        
        // Group activities by date
        $itinerary = $trip->activities->groupBy(function($activity) {
            return \Carbon\Carbon::parse($activity->date)->format('Y-m-d');
        });

        $totalSpent = $trip->expenses->where('type', 'expense')->whereNull('deleted_at')->sum('amount');
        $remaining = ($trip->budget ?? 0) - $totalSpent;

        $settlementParticipants = $trip->sharedUsers
            ->where('pivot.is_accepted', true)
            ->push($trip->user)
            ->unique('id')
            ->values();

        $sharedExpenses = $trip->expenses->where('type', 'expense')->whereNull('deleted_at');
        $participantCount = max($settlementParticipants->count(), 1);
        $sharePerPerson = round($sharedExpenses->sum('amount') / $participantCount, 2);

        $settlementBalances = $settlementParticipants->map(function ($member) use ($sharedExpenses, $sharePerPerson) {
            $paidAmount = $sharedExpenses->where('paid_by', $member->id)->sum('amount');

            return [
                'user' => $member,
                'paid' => round($paidAmount, 2),
                'share' => $sharePerPerson,
                'balance' => round($paidAmount - $sharePerPerson, 2),
            ];
        })->values();

        $creditors = $settlementBalances->filter(fn ($member) => $member['balance'] > 0)->sortByDesc('balance')->values()->all();
        $debtors = $settlementBalances->filter(fn ($member) => $member['balance'] < 0)->sortBy('balance')->values()->all();

        $settlementTransfers = collect();
        $creditorIndex = 0;

        foreach ($debtors as $debtor) {
            $remainingDebt = abs($debtor['balance']);

            while ($remainingDebt > 0.01 && isset($creditors[$creditorIndex])) {
                $creditor = $creditors[$creditorIndex];
                $availableCredit = $creditor['balance'];
                $amount = round(min($remainingDebt, $availableCredit), 2);

                if ($amount > 0) {
                    $settlementTransfers->push([
                        'from' => $debtor['user'],
                        'to' => $creditor['user'],
                        'amount' => $amount,
                    ]);
                }

                $remainingDebt = round($remainingDebt - $amount, 2);
                $creditors[$creditorIndex]['balance'] = round($availableCredit - $amount, 2);

                if ($creditors[$creditorIndex]['balance'] <= 0.01) {
                    $creditorIndex++;
                }
            }
        }

        // Resolve inviter users
        $invitedUserIds = $trip->sharedUsers->pluck('pivot.invited_by')->filter()->unique();
        $guestInvitedUserIds = $trip->invitations->pluck('invited_by')->filter()->unique();
        $allInviterIds = $invitedUserIds->merge($guestInvitedUserIds)->unique();
        $inviters = \App\Models\User::whereIn('id', $allInviterIds)->get()->keyBy('id');

        return view('trips.show', compact('trip', 'itinerary', 'totalSpent', 'remaining', 'inviters', 'settlementParticipants', 'sharedExpenses', 'sharePerPerson', 'settlementBalances', 'settlementTransfers'));
    }

    /**
     * Show the form for editing the specified trip.
     */
    public function edit(Trip $trip)
    {
        $this->authorizeTrip($trip, 'editor'); // Only owners or editors can edit
        return view('trips.edit', compact('trip'));
    }

    /**
     * Update the specified trip in storage.
     */
    public function update(Request $request, Trip $trip)
    {
        $this->authorizeTrip($trip, 'editor');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:upcoming,active,completed,cancelled',
            'image_url' => 'nullable|url',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $trip->update($validated);

        return redirect()->route('trips.show', $trip)->with('success', 'Trip updated successfully!');
    }

    /**
     * Update quick shared notes for the trip.
     */
    public function updateQuickNotes(Request $request, Trip $trip)
    {
        $this->authorizeTrip($trip, 'editor');

        $validated = $request->validate([
            'quick_notes' => 'nullable|string|max:1000',
        ]);

        $trip->update(['quick_notes' => $validated['quick_notes'] ?? null]);

        return redirect()->route('trips.show', $trip)->with('success', 'Quick notes updated.');
    }

    /**
     * Remove the specified trip from storage.
     */
    public function destroy(Trip $trip)
    {
        $this->authorizeTrip($trip, 'owner'); // Only owners can delete
        $trip->delete();

        return redirect()->route('trips.index')->with('success', 'Trip deleted successfully.');
    }

    /**
     * Store a new activity for the trip.
     */
    public function storeActivity(Request $request, Trip $trip)
    {
        $this->authorizeTrip($trip, 'editor');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'type' => 'required|in:transport,accommodation,activity,dining,other',
            'custom_type' => 'nullable|string|max:255',
            'is_completed' => 'nullable|boolean',
        ]);

        if ($validated['type'] === 'other' && !empty($validated['custom_type'])) {
            $validated['type'] = $validated['custom_type'];
        }

        unset($validated['custom_type']);

        $trip->activities()->create($validated);

        return redirect()->route('trips.show', $trip)->with('success', 'Activity added to your itinerary!');
    }

    /**
     * Update an activity for the trip.
     */
    public function updateActivity(Request $request, Trip $trip, \App\Models\ItineraryActivity $activity)
    {
        $this->authorizeTrip($trip, 'editor');

        if ($activity->trip_id !== $trip->id) {
            abort(404, 'Activity not found in this trip.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'type' => 'required|in:transport,accommodation,activity,dining,other',
            'custom_type' => 'nullable|string|max:255',
        ]);

        if ($validated['type'] === 'other' && !empty($validated['custom_type'])) {
            $validated['type'] = $validated['custom_type'];
        }

        unset($validated['custom_type']);

        // Normalize checkbox input: presence means completed, absence means not completed
        $validated['is_completed'] = $request->has('is_completed');

        $activity->update($validated);

        return redirect()->route('trips.show', $trip)->with('success', 'Activity updated successfully!');
    }

    /**
     * Delete an activity from the trip.
     */
    public function deleteActivity(Trip $trip, \App\Models\ItineraryActivity $activity)
    {
        $this->authorizeTrip($trip, 'editor');

        if ($activity->trip_id !== $trip->id) {
            abort(404, 'Activity not found in this trip.');
        }

        $activity->delete();

        return redirect()->route('trips.show', $trip)->with('success', 'Activity deleted successfully!');
    }

    /**
     * Mark an activity as completed for the trip.
     */
    public function completeActivity(Request $request, Trip $trip, \App\Models\ItineraryActivity $activity)
    {
        $this->authorizeTrip($trip, 'editor');

        if ($activity->trip_id !== $trip->id) {
            abort(404, 'Activity not found in this trip.');
        }

        $activity->update(['is_completed' => true]);

        return redirect()->route('trips.show', $trip)->with('success', 'Activity marked as completed.');
    }

    /**
     * Mark an activity as not completed for the trip.
     */
    public function undoCompleteActivity(Request $request, Trip $trip, \App\Models\ItineraryActivity $activity)
    {
        $this->authorizeTrip($trip, 'editor');

        if ($activity->trip_id !== $trip->id) {
            abort(404, 'Activity not found in this trip.');
        }

        $activity->update(['is_completed' => false]);

        return redirect()->route('trips.show', $trip)->with('success', 'Activity marked as not completed.');
    }

    /**
     * Store a new expense for the trip.
     */
    public function storeExpense(Request $request, Trip $trip)
    {
        $this->authorizeTrip($trip, 'editor');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'custom_category' => 'nullable|string|max:255',
            'paid_by' => 'required|integer|exists:users,id',
        ]);

        if ($validated['category'] === 'other' && !empty($validated['custom_category'])) {
            $validated['category'] = $validated['custom_category'];
        }
        unset($validated['custom_category']);

        $validated['user_id'] = Auth::id();

        $trip->expenses()->create($validated);

        return redirect()->route('trips.show', $trip)->with('success', 'Expense added successfully!');
    }

    /**
     * Update the trip budget.
     */
    public function updateBudget(Request $request, Trip $trip)
    {
        $this->authorizeTrip($trip, 'editor');

        $validated = $request->validate([
            'budget' => 'required|numeric|min:1',
            'paid_by' => 'required|integer|exists:users,id',
        ]);

        $amount = $validated['budget'];

        $trip->expenses()->create([
            'user_id' => Auth::id(),
            'type' => 'budget',
            'title' => $trip->budget ? 'Budget Added' : 'Initial Budget',
            'amount' => $amount,
            'category' => 'budget',
            'paid_by' => $validated['paid_by'],
        ]);

        $newTotal = ($trip->budget ?? 0) + $amount;
        $trip->update(['budget' => $newTotal]);

        return redirect()->route('trips.show', $trip)->with('success', 'Budget updated successfully!');
    }

    /**
     * Add a member to the trip.
     */
    public function addMember(Request $request, Trip $trip)
    {
        $this->authorizeTrip($trip, 'editor');

        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:editor,viewer',
        ]);

        $email = trim(strtolower($request->email));

        // 1. Prevent inviting oneself (the owner)
        if ($email === strtolower($trip->user->email)) {
            return back()->with('error', 'You cannot invite yourself since you are the owner of this trip.');
        }

        // 2. Check if this is an existing registered user
        $user = \App\Models\User::whereRaw('LOWER(email) = ?', [$email])->first();

        if ($user) {
            // Check if already in sharedUsers
            $existingShared = $trip->sharedUsers()->where('user_id', $user->id)->first();
            if ($existingShared) {
                if ($existingShared->pivot->is_accepted) {
                    return back()->with('error', $user->name . ' has already accepted and joined this trip.');
                } else {
                    return back()->with('error', $user->name . ' already has a pending invitation to this trip.');
                }
            }

            // Attach registered user as pending invite
            $trip->sharedUsers()->attach($user->id, [
                'role' => $request->role,
                'is_accepted' => false,
                'invited_by' => Auth::id(),
            ]);

            $this->emailService->sendTripInvitation($trip, $user->email, Auth::user(), $request->role, true);

            return redirect()->route('trips.show', $trip)->with('success', 'Invitation sent to ' . $user->name . '! They can accept and join from their dashboard.');
        }

        // 3. For unregistered emails, check if already invited in trip_invitations
        $existingInvite = $trip->invitations()->where('email', $email)->exists();
        if ($existingInvite) {
            return back()->with('error', 'An invitation has already been sent to ' . $email . '.');
        }

        // Create a guest invitation
        $trip->invitations()->create([
            'email' => $email,
            'role' => $request->role,
            'invited_by' => Auth::id(),
        ]);

        $this->emailService->sendTripInvitation($trip, $email, Auth::user(), $request->role, false);

        return redirect()->route('trips.show', $trip)->with('success', 'Invitation sent to ' . $email . '! They can join once they register.');
    }

    /**
     * Accept a pending trip invitation.
     */
    public function acceptInvitation(Trip $trip)
    {
        $membership = $trip->sharedUsers()->where('user_id', Auth::id())->first();

        if (!$membership) {
            abort(403, 'You do not have a pending invitation for this trip.');
        }

        if ($membership->pivot->is_accepted) {
            return redirect()->route('trips.show', $trip)->with('info', 'You have already joined this trip.');
        }

        $trip->sharedUsers()->updateExistingPivot(Auth::id(), [
            'is_accepted' => true,
        ]);

        $trip->load(['user', 'sharedUsers']);
        $this->emailService->notifyTripMembersJoined($trip, Auth::user());

        return redirect()->route('trips.show', $trip)->with('success', 'You have joined the trip successfully!');
    }

    /**
     * Decline a pending trip invitation.
     */
    public function declineInvitation(Trip $trip)
    {
        $membership = $trip->sharedUsers()->where('user_id', Auth::id())->first();

        if (!$membership) {
            abort(403, 'You do not have a pending invitation for this trip.');
        }

        $trip->sharedUsers()->detach(Auth::id());

        return redirect()->route('home')->with('success', 'Invitation declined successfully.');
    }

    /**
     * Cancel a guest invitation.
     */
    public function cancelInvitation(Trip $trip, TripInvitation $invitation)
    {
        $this->authorizeTrip($trip, 'owner');

        if ($invitation->trip_id !== $trip->id) {
            abort(404, 'Invitation not found for this trip.');
        }

        $invitation->delete();

        return redirect()->route('trips.show', $trip)->with('success', 'Invitation canceled successfully.');
    }

    /**
     * Remove a member from the trip.
     */
    public function removeMember(Trip $trip, \App\Models\User $user)
    {
        $this->authorizeTrip($trip, 'owner');

        $trip->sharedUsers()->detach($user->id);

        return redirect()->route('trips.show', $trip)->with('success', 'Member removed from the trip.');
    }

    /**
     * Update an expense.
     */
    public function updateExpense(Request $request, Trip $trip, \App\Models\Expense $expense)
    {
        $this->authorizeTrip($trip, 'editor');

        if ($expense->trip_id !== $trip->id) {
            abort(404, 'Expense not found in this trip.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'paid_by' => 'nullable|integer|exists:users,id',
        ]);

        $validated['edited_by'] = Auth::id();
        $expense->update($validated);

        if ($expense->type === 'budget') {
            $budgetTotal = $trip->expenses()->where('type', 'budget')->sum('amount');
            $trip->update(['budget' => $budgetTotal]);
        }

        return redirect()->route('trips.show', $trip)->with('success', 'Expense updated successfully!');
    }

    /**
     * Delete an expense (soft delete).
     */
    public function deleteExpense(Trip $trip, \App\Models\Expense $expense)
    {
        $this->authorizeTrip($trip, 'editor');

        if ($expense->trip_id !== $trip->id) {
            abort(404, 'Expense not found in this trip.');
        }

        $expense->update(['deleted_by' => Auth::id()]);
        $expense->delete();

        if ($expense->type === 'budget') {
            $budgetTotal = $trip->expenses()->where('type', 'budget')->sum('amount');
            $trip->update(['budget' => $budgetTotal]);
        }

        return redirect()->route('trips.show', $trip)->with('success', 'Expense deleted successfully!');
    }

    /**
     * Authorize that the trip belongs to the authenticated user or they are a member.
     */
    protected function authorizeTrip(Trip $trip, $minRole = 'viewer')
    {
        $userId = Auth::id();
        
        if ($trip->user_id === $userId) {
            return true;
        }

        $membership = $trip->sharedUsers()->where('user_id', $userId)->first();
        
        if (!$membership) {
            abort(403, 'Unauthorized action.');
        }

        if ($minRole === 'editor' && $membership->pivot->role === 'viewer') {
            abort(403, 'You do not have permission to edit this trip.');
        }

        if ($minRole === 'owner') {
            abort(403, 'Only the trip owner can perform this action.');
        }

        return true;
    }
}
