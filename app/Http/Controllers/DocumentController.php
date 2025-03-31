<?php

namespace App\Http\Controllers;

use App\Models\{Exam, ExamResult, Document, User};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function releve(User $student)
    {
        $grades = $student->examResults()->with('exam.module')->get();
        $average = $grades->avg('grade');

        $pdf = Pdf::loadView('documents.releve', compact('student', 'grades', 'average'));

        $filename = 'releve_notes_' . $student->id . '_' . now()->timestamp . '.pdf';
        $filePath = 'documents/releves/' . $filename;
        Storage::disk('public')->put($filePath, $pdf->output());

        Document::create([
            'type' => 'releve_notes',
            'file_path' => $filePath,
            'student_id' => $student->id,
            'generated_by' => auth()->id(),
        ]);

        return response()->download(storage_path('app/public/' . $filePath));
    }

    public function downloadReleve()
    {
        $student = Auth::user();

        if (!$student->isEtudiant()) {
            abort(403);
        }

        return $this->releve($student);
    }

    public function pv($examId)
    {
        $exam = Exam::with(['module', 'group', 'rooms', 'results.student'])->findOrFail($examId);
        return view('documents.pv', compact('exam'));
    }

    public function generatePV($examId)
    {
        $this->authorizeRole('directeur_pedagogique');

        $exam = Exam::with(['module', 'group', 'results.student'])->findOrFail($examId);
        $pdf = Pdf::loadView('documents.pv', compact('exam'));

        $filename = 'pv_notes_module_' . $exam->module->code . '_' . now()->timestamp . '.pdf';
        $filePath = 'documents/pv/' . $filename;
        Storage::disk('public')->put($filePath, $pdf->output());

        Document::create([
            'type' => 'pv_notes',
            'file_path' => $filePath,
            'exam_id' => $exam->id,
            'generated_by' => auth()->id(),
        ]);

        return response()->download(storage_path('app/public/' . $filePath));
    }

    public function downloadAttestation($studentId = null)
    {
        $user = Auth::user();

        if ($user->isEtudiant()) {
            $student = $user;
        } elseif ($user->isDirecteurPedagogique()) {
            if (!$studentId) {
                abort(400, 'Identifiant étudiant requis.');
            }
            $student = User::where('user_type', 'etudiant')->findOrFail($studentId);
        } else {
            abort(403);
        }

        $average = ExamResult::where('student_id', $student->id)->avg('grade') ?? 0;

        $pdf = Pdf::loadView('documents.attestation', [
            'student' => $student,
            'average' => $average,
            'location' => 'ESRMI',
        ]);

        $filename = 'attestation_' . str_replace(' ', '_', strtolower($student->name)) . '_' . now()->timestamp . '.pdf';
        $filePath = 'documents/attestations/' . $filename;

        Storage::disk('public')->put($filePath, $pdf->output());

        Document::create([
            'type' => 'attestation_reussite',
            'file_path' => $filePath,
            'student_id' => $student->id,
            'generated_by' => auth()->id(),
        ]);

        return response()->download(storage_path('app/public/' . $filePath));
    }

    public function attestations()
    {
        $this->authorizeRole('directeur_pedagogique');
        $students = User::where('user_type', 'etudiant')->with('group')->get();
        return view('documents.attestations', compact('students'));
    }

    public function showAttestation($studentId = null)
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
        return view('documents.attestation', compact('student', 'average'));
    }

    protected function authorizeRole($role)
    {
        if (Auth::user()->user_type !== $role) {
            abort(403);
        }
    }
}
