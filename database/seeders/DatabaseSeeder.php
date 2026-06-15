<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $demoUser = User::firstOrCreate(
            ['email' => '5860vaibhav@gmail.com'],
            ['name' => 'Vaibhav Demo', 'password' => 'password']
        );

        $inviter = User::firstOrCreate(
            ['email' => 'inviter@example.com'],
            ['name' => 'Ava Tripmate', 'password' => 'password']
        );

        $trip = Trip::firstOrCreate(
            ['title' => 'Goa Weekend Escape', 'user_id' => $inviter->id],
            [
                'destination' => 'Goa, India',
                'start_date' => Carbon::now()->addDays(12)->toDateString(),
                'end_date' => Carbon::now()->addDays(15)->toDateString(),
                'description' => 'Beach time, cafes, and sunset cruising.',
                'status' => 'upcoming',
            ]
        );

        $trip->sharedUsers()->sync([
            $demoUser->id => [
                'role' => 'editor',
                'is_accepted' => false,
                'invited_by' => $inviter->id,
            ],
        ], false);
    }
}
