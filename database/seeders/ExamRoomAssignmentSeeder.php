<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamRoomSeeder extends Seeder
{
    public function run(): void
    {
        $exams = Exam::where('status', '!=', 'canceled')->get();
        $rooms = Room::all();
        
        foreach ($exams as $exam) {
            // Get the group's student count
            $studentCount = $exam->group->users()->where('user_type', 'etudiant')->count();
            
            // Select rooms with enough total capacity for the students
            $roomsNeeded = [];
            $currentCapacity = 0;
            
            // Shuffle rooms for random selection
            $shuffledRooms = $rooms->shuffle();
            
            foreach ($shuffledRooms as $room) {
                $roomsNeeded[] = $room;
                $currentCapacity += $room->capacity;
                
                if ($currentCapacity >= $studentCount) {
                    break;
                }
            }
            
            // Assign selected rooms to the exam
            foreach ($roomsNeeded as $room) {
                DB::table('exam_room')->insert([
                    'exam_id' => $exam->id,
                    'room_id' => $room->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}