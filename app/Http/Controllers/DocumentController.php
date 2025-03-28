<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ✅ List all exams (for teachers or directors)
    public function index()
    {
        $user = auth()->user();

        if ($user->isEnseignant()) {
            $moduleIds = $user->modules->pluck('id');
            $exams = Exam::whereIn('module_id', $moduleIds)->with('module', 'group')->get();
            return view('documents.index', compact('exams'));
        }

        if ($user->isDirecteurPedagogique()) {
            $exams = Exam::with('module', 'group')->get();
            return view('documents.index', compact('exams'));
        }

        abort(403);
    }

    // ✅ Relevé de notes for a specific student (PDF)
    public function releve(User $student)
    {
        $grades = $student->examResults()->with('exam.module')->get();
        $average = $grades->avg('grade');

        $pdf = Pdf::loadView('documents.releve', [
            'student' => $student,
            'grades' => $grades,
            'average' => $average,
        ]);

        return $pdf->download('releve_notes_' . $student->id . '.pdf');
    }

    // ✅ Relevé de notes (PDF) for the logged-in student
    public function downloadReleve()
    {
        $student = Auth::user();

        if (!$student->isEtudiant()) {
            abort(403);
        }

        $grades = $student->examResults()->with('exam.module')->get();
        $average = $grades->avg('grade');

        $pdf = Pdf::loadView('documents.releve', [
            'student' => $student,
            'grades' => $grades,
            'average' => $average,
        ]);

        return $pdf->download('releve_notes.pdf');
    }

    // ✅ PV view only (HTML display)
    public function pv($examId)
    {
        $exam = Exam::with(['module', 'group', 'rooms', 'results.student'])->findOrFail($examId);
        return view('documents.pv', compact('exam'));
    }

    // ✅ PV generation (PDF) for director
    public function generatePV($examId)
    {
        $this->authorizeRole('directeur_pedagogique');

        $exam = Exam::with(['module', 'group', 'results.student'])->findOrFail($examId);

        $pdf = Pdf::loadView('documents.pv', compact('exam'));
        return $pdf->download("pv_notes_module_{$exam->module->name}.pdf");
    }

    // ✅ Attestation PDF for student or director
    public function downloadAttestation($studentId = null)
    {
        $user = Auth::user();

        if ($user->isEtudiant()) {
            $student = $user;
        } elseif ($user->isDirecteurPedagogique()) {
            $student = User::where('user_type', 'etudiant')->findOrFail($studentId);
        } else {
            abort(403);
        }

        $average = ExamResult::where('student_id', $student->id)->avg('grade');

        $pdf = Pdf::loadView('documents.attestation', compact('student', 'average'));
        return $pdf->download("attestation_{$student->name}.pdf");
    }

    // ✅ Role check utility
    protected function authorizeRole($role)
    {
        if (Auth::user()->user_type !== $role) {
            abort(403);
        }
    }
}
