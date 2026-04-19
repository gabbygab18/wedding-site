<?php

namespace Database\Seeders;

use App\Models\Wedding;
use App\Models\EntourageMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@wedding.local'],
            [
                'name'     => 'Wedding Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Create sample wedding
        $wedding = Wedding::firstOrCreate(
            ['bride_name' => 'Sofia'],
            [
                'bride_name'     => 'Sofia Reyes',
                'groom_name'     => 'Miguel Santos',
                'wedding_date'   => now()->addMonths(6)->toDateString(),
                'ceremony_time'  => '10:00:00',
                'reception_time' => '12:00:00',
                'venue_name'     => 'Sanctuario de San Antonio',
                'venue_address'  => 'Forbes Park, Makati City, Metro Manila',
                'reception_venue'=> 'The Peninsula Manila',
                'love_story'     => "It started with a chance encounter at a friend's birthday party in 2019. Sofia was drawn to Miguel's quiet laughter, and Miguel couldn't stop noticing how Sofia's eyes lit up when she talked about things she loved.\n\nThey spent months as friends before admitting what everyone around them already knew — that they were meant for each other. Four years later, here they are, ready to begin forever.",
                'hashtag'        => 'ForeverSofiaAndMiguel',
                'rsvp_enabled'   => true,
                'rsvp_deadline'  => now()->addMonths(5)->toDateString(),
            ]
        );

        // Sample entourage
        $entourage = [
            ['name' => 'Carlos Santos',   'role' => 'Best Man',          'side' => 'Groom'],
            ['name' => 'Andrea Reyes',    'role' => 'Maid of Honor',     'side' => 'Bride'],
            ['name' => 'Paolo Mendoza',   'role' => 'Groomsman',         'side' => 'Groom'],
            ['name' => 'Marco Villanueva','role' => 'Groomsman',         'side' => 'Groom'],
            ['name' => 'Isabelle Cruz',   'role' => 'Bridesmaid',        'side' => 'Bride'],
            ['name' => 'Camille Torres',  'role' => 'Bridesmaid',        'side' => 'Bride'],
            ['name' => 'Lola Reyes',      'role' => 'Principal Sponsor', 'side' => 'Bride'],
            ['name' => 'Tito Ben Santos', 'role' => 'Principal Sponsor', 'side' => 'Groom'],
            ['name' => 'Lucia Hernandez', 'role' => 'Secondary Sponsor', 'side' => null],
            ['name' => 'Baby Sophia',     'role' => 'Flower Girl',       'side' => null],
            ['name' => 'Little Mateo',    'role' => 'Ring Bearer',       'side' => null],
        ];

        foreach ($entourage as $member) {
            EntourageMember::firstOrCreate(
                ['wedding_id' => $wedding->id, 'name' => $member['name']],
                array_merge($member, ['wedding_id' => $wedding->id])
            );
        }
    }
}
