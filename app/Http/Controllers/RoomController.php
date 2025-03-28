<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Exam;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:directeur_pedagogique']);
    }

    public function index()
    {
        $rooms = Room::with('exams')->get();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:rooms,name',
            'capacity' => 'required|integer|min:1',
        ]);

        Room::create($request->only(['name', 'capacity']));

        return redirect()->route('rooms.index')->with('success', 'Salle créée avec succès.');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255|unique:rooms,name,' . $room->id,
            'capacity' => 'required|integer|min:1',
        ]);

        $room->update($request->only(['name', 'capacity']));

        return redirect()->route('rooms.index')->with('success', 'Salle mise à jour.');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Salle supprimée.');
    }

    // Optional: View assigned exams to a room
    public function exams($roomId)
    {
        $room = \App\Models\Room::findOrFail($roomId);
    
        $exams = \App\Models\Exam::with(['module', 'group'])
            ->whereHas('rooms', function ($query) use ($roomId) {
                $query->where('room_id', $roomId);
            })
            ->get();
    
        return view('rooms.exams', compact('room', 'exams'));
    }
    
}
