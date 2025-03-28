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

    // ✅ Generate Relevé de Notes (Student Grade Report)
    public function downloadReleve()
    {
        $student = Auth::user();

        if (!$student->isEtudiant()) {
            abort(403);
        }

        $results = ExamResult::where('student_id', $student->id)
            ->with('exam.module')
            ->get();

        $pdf = PDF::loadView('documents.releve', compact('student', 'results'));
        return $pdf->download('releve_notes.pdf');
    }

    // ✅ Generate PV de Notes (Director: results by module/group)
    public function generatePV($examId)
    {
        $this->authorizeRole('directeur_pedagogique');

        $exam = Exam::with(['module', 'group', 'results.student'])->findOrFail($examId);

        $pdf = PDF::loadView('documents.pv', compact('exam'));
        return $pdf->download("pv_notes_module_{$exam->module->name}.pdf");
    }

    // ✅ Generate Attestation de Réussite (Student or Director)
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

        $pdf = PDF::loadView('documents.attestation', compact('student', 'average'));
        return $pdf->download("attestation_{$student->name}.pdf");
    }

    protected function authorizeRole($role)
    {
        if (Auth::user()->user_type !== $role) {
            abort(403);
        }
    }
}
