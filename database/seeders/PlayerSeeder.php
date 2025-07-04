<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tournament;
use App\Models\Score;
use Illuminate\Support\Facades\Hash;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample players
        $players = [
            [
                'Name' => 'John Smith',
                'Email' => 'john.smith@golf.com',
                'Password' => Hash::make('password123'),
                'Role' => 'player',
                'RegistrationDate' => now(),
            ],
            [
                'Name' => 'Sarah Johnson',
                'Email' => 'sarah.johnson@golf.com',
                'Password' => Hash::make('password123'),
                'Role' => 'player',
                'RegistrationDate' => now(),
            ],
            [
                'Name' => 'Mike Wilson',
                'Email' => 'mike.wilson@golf.com',
                'Password' => Hash::make('password123'),
                'Role' => 'player',
                'RegistrationDate' => now(),
            ],
            [
                'Name' => 'Emily Davis',
                'Email' => 'emily.davis@golf.com',
                'Password' => Hash::make('password123'),
                'Role' => 'player',
                'RegistrationDate' => now(),
            ],
            [
                'Name' => 'Admin User',
                'Email' => 'admin@golf.com',
                'Password' => Hash::make('admin123'),
                'Role' => 'admin',
                'RegistrationDate' => now(),
            ],
        ];

        foreach ($players as $playerData) {
            User::create($playerData);
        }

        // Create sample tournament
        $tournament = Tournament::create([
            'Name' => 'Summer Championship 2025',
            'StartDate' => '2025-08-15',
            'EndDate' => '2025-08-18',
            'Location' => 'Augusta National Golf Club',
            'Description' => 'Annual summer golf championship tournament',
            'PrizePool' => 50000.00,
            'Status' => 'upcoming',
        ]);

        // Create sample scores for players
        $playerUsers = User::where('Role', 'player')->get();
        
        foreach ($playerUsers as $player) {
            // Create scores for 18 holes (Round 1)
            for ($hole = 1; $hole <= 18; $hole++) {
                Score::create([
                    'UserID' => $player->UserID,
                    'TournamentID' => $tournament->TournamentID,
                    'Round' => 1,
                    'Hole' => $hole,
                    'Strokes' => rand(3, 7), // Random strokes between 3-7
                    'Par' => ($hole <= 6) ? 4 : (($hole <= 12) ? 3 : 5), // Mix of par 3, 4, 5
                ]);
            }
        }

        $this->command->info('Players, tournament, and scores seeded successfully!');
    }
}
