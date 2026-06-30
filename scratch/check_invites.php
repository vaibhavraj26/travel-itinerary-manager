<?php

use App\Models\User;
use App\Models\Trip;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    DB::beginTransaction();

    // 1. Get or create Owner, Editor, and Member
    $owner = User::firstOrCreate(
        ['email' => 'owner@example.com'],
        ['name' => 'Owner User', 'password' => bcrypt('password')]
    );
    $editor = User::firstOrCreate(
        ['email' => 'editor@example.com'],
        ['name' => 'Editor User', 'password' => bcrypt('password')]
    );
    $newMember = User::firstOrCreate(
        ['email' => 'member@example.com'],
        ['name' => 'New Member User', 'password' => bcrypt('password')]
    );

    // Clean up any existing shared relationship for test reliability
    DB::table('trip_user')->truncate();

    // 2. Owner creates a Trip
    $trip = Trip::create([
        'user_id' => $owner->id,
        'title' => 'Test Trip',
        'destination' => 'Paris',
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(10)->toDateString(),
        'status' => 'upcoming'
    ]);
    echo "Trip created by owner: ID {$trip->id}, Title: {$trip->title}\n";

    // 3. Owner adds Editor to the Trip (is_accepted = true)
    $trip->sharedUsers()->attach($editor->id, [
        'role' => 'editor',
        'is_accepted' => true,
        'invited_by' => $owner->id
    ]);
    echo "Editor attached to trip (Accepted)\n";

    // 4. Editor invites New Member to the Trip (is_accepted = false, invited_by = Editor)
    $trip->sharedUsers()->attach($newMember->id, [
        'role' => 'viewer',
        'is_accepted' => false,
        'invited_by' => $editor->id
    ]);
    echo "New Member invited by Editor (Pending, invited_by: {$editor->id})\n";

    // 5. Query the New Member's pending invitations (Simulating Dashboard query)
    $pending = $newMember->sharedTrips()
        ->wherePivot('is_accepted', false)
        ->get();
    
    echo "Pending count for New Member: " . $pending->count() . "\n";
    foreach ($pending as $t) {
        $inviterName = User::find($t->pivot->invited_by)?->name ?? 'Unknown';
        echo "- Found Trip #{$t->id}: '{$t->title}', Invited by: {$inviterName}, Role: {$t->pivot->role}\n";
    }

    // 6. Test accepting invitation logic
    $membership = $trip->sharedUsers()->where('user_id', $newMember->id)->first();
    if ($membership) {
        echo "Found membership for accept test!\n";
        echo "Is accepted value: " . ($membership->pivot->is_accepted ? 'true' : 'false') . "\n";
        
        // Simulating accepted state update
        $trip->sharedUsers()->updateExistingPivot($newMember->id, [
            'is_accepted' => true
        ]);
        
        $membershipUpdated = $trip->sharedUsers()->where('user_id', $newMember->id)->first();
        echo "After accept update, is_accepted: " . ($membershipUpdated->pivot->is_accepted ? 'true' : 'false') . "\n";
    } else {
        echo "Membership not found for accept test!\n";
    }

    DB::rollBack();
    echo "Test completed successfully and rolled back.\n";

} catch (\Exception $e) {
    DB::rollBack();
    echo "Error encountered: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
