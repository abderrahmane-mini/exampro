<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'A101',
                'capacity' => 40,
                'building' => 'Building A',
            ],
            [
                'name' => 'A102',
                'capacity' => 40,
                'building' => 'Building A',
            ],
            [
                'name' => 'A201',
                'capacity' => 30,
                'building' => 'Building A',
            ],
            [
                'name' => 'B101',
                'capacity' => 80,
                'building' => 'Building B',
            ],
            [
                'name' => 'B102',
                'capacity' => 60,
                'building' => 'Building B',
            ],
            [
                'name' => 'C101',
                'capacity' => 100,
                'building' => 'Building C',
            ],
            [
                'name' => 'C201',
                'capacity' => 60,
                'building' => 'Building C',
            ],
            [
                'name' => 'C202',
                'capacity' => 60,
                'building' => 'Building C',
            ],
            [
                'name' => 'Lab 1',
                'capacity' => 25,
                'building' => 'IT Building',
            ],
            [
                'name' => 'Lab 2',
                'capacity' => 25,
                'building' => 'IT Building',
            ],
            [
                'name' => 'Conference Hall',
                'capacity' => 200,
                'building' => 'Main Building',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}