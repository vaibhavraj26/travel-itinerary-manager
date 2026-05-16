<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    /**
     * Display a listing of the trips.
     */
    public function index()
    {
        $trips = Auth::user()->trips()->latest()->get();
        return view('trips.index', compact('trips'));
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
        ]);

        Auth::user()->trips()->create($validated);

        return redirect()->route('trips.index')->with('success', 'Adventure planned successfully!');
    }

    /**
     * Display the specified trip.
     */
    public function show(Trip $trip)
    {
        $this->authorizeTrip($trip);
        $trip->load(['activities', 'sharedUsers']);
        
        // Group activities by date
        $itinerary = $trip->activities->groupBy(function($activity) {
            return \Carbon\Carbon::parse($activity->date)->format('Y-m-d');
        });

        return view('trips.show', compact('trip', 'itinerary'));
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
        ]);

        $trip->update($validated);

        return redirect()->route('trips.show', $trip)->with('success', 'Trip updated successfully!');
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
        ]);

        $trip->activities()->create($validated);

        return redirect()->route('trips.show', $trip)->with('success', 'Activity added to your itinerary!');
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
        ]);

        $trip->expenses()->create($validated);

        return redirect()->route('trips.show', $trip)->with('success', 'Expense added successfully!');
    }

    /**
     * Add a member to the trip.
     */
    public function addMember(Request $request, Trip $trip)
    {
        $this->authorizeTrip($trip, 'owner');

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|in:editor,viewer',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user->id === $trip->user_id) {
            return back()->with('error', 'You are already the owner of this trip.');
        }

        if ($trip->sharedUsers()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'This user is already a member of the trip.');
        }

        $trip->sharedUsers()->attach($user->id, ['role' => $request->role]);

        return redirect()->route('trips.show', $trip)->with('success', $user->name . ' has been added to the trip!');
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
