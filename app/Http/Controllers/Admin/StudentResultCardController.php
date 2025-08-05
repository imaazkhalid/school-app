<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use PDF;

class StudentResultCardController extends Controller
{
    public function download(Student $student)
    {
        $student->load(['user', 'enrollments.section.course']);
        $pdf = PDF::loadView('livewire.admin.students.result-card', compact('student'));
        return $pdf->download('result_card_'.$student->student_id.'.pdf');
    }
}
