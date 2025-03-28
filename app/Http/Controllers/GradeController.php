<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ✅ Teachers select an exam to enter grades
    public function selectExam()
    {
        $teacher = Auth::user();
        $exams = Exam::whereIn('module_id', $teacher->modules->pluck('id'))->get();
        return view('grades.select_exam', compact('exams'));
    }

    // ✅ Grade entry form for an exam
    public function enter($examId)
    {
        $exam = Exam::with('group.students')->findOrFail($examId);
        return view('grades.enter', compact('exam'));
    }

    // ✅ Save submitted grades
    public function store(Request $request, $examId)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'numeric|min:0|max:20',
        ]);

        foreach ($request->grades as $studentId => $grade) {
            ExamResult::updateOrCreate(
                ['exam_id' => $examId, 'student_id' => $studentId],
                ['grade' => $grade]
            );
        }

        return redirect()->route('enseignant.grades.view')->with('success', 'Notes enregistrées.');
    }

    // ✅ View grades (by teacher or director)
    public function view()
    {
        $user = Auth::user();

        if ($user->isEnseignant()) {
            $examIds = Exam::whereIn('module_id', $user->modules->pluck('id'))->pluck('id');
            $grades = ExamResult::whereIn('exam_id', $examIds)->with('exam.module', 'student')->get();
        } elseif ($user->isDirecteurPedagogique()) {
            $grades = ExamResult::with('exam.module', 'student')->get();
        } else {
            abort(403);
        }

        return view('grades.view', compact('grades'));
    }

    // ✅ Calculate averages
    public function calculateAverages()
    {
        $this->authorizeRole('directeur_pedagogique');

        $moduleAverages = ExamResult::with('exam.module')
            ->get()
            ->groupBy(fn($r) => $r->exam->module->name)
            ->map(fn($r) => round($r->avg('grade'), 2));

        $studentAverages = ExamResult::with('student')
            ->get()
            ->groupBy('student_id')
            ->map(function ($results) {
                return [
                    'student' => $results->first()->student->name ?? 'Inconnu',
                    'average' => round($results->avg('grade'), 2),
                ];
            });

        return view('grades.averages', compact('moduleAverages', 'studentAverages'));
    }

    protected function authorizeRole($role)
    {
        if (Auth::user()->user_type !== $role) {
            abort(403);
        }
    }
}
