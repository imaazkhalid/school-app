<?php

namespace App\Livewire\Teacher\Section;

use App\Helpers\GradeHelper;
use App\Models\Enrollment;
use App\Models\Section;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Manage Grades')]
class Grades extends Component
{
    public Section $section;
    public $enrollments;
    public $editEnrollmentId = null;
    public $editMarks = null;
    public $editStudentName = null;
    public $enrollment = null;

    public function mount(Section $section)
    {
        Gate::authorize('update', $section);

        $this->section = $section;
        $this->loadEnrollments();
    }

    public function loadEnrollments(): void
    {
        $this->enrollments = $this->section->enrollments()->with('student.user')->get();
    }

    public function openEditModal($enrollmentId)
    {
        $this->enrollment = Enrollment::findOrFail($enrollmentId);
        $this->editEnrollmentId = $this->enrollment->id;
        $this->editMarks = $this->enrollment->marks;
        $this->editStudentName = $this->enrollment->student->user->name;
    }

    public function saveGrade()
    {
        $this->validate([
            'editMarks' => 'required|numeric|min:0|max:100',
        ]);

        $grade = GradeHelper::fromMarks($this->editMarks);
//        $enrollment = Enrollment::findOrFail($this->editEnrollmentId);
        $this->enrollment->marks = $this->editMarks;
        $this->enrollment->grade = $grade;
        $this->enrollment->save();

        $this->loadEnrollments();
        $this->editEnrollmentId = null;
        $this->editMarks = null;
        $this->editStudentName = null;
        $this->enrollment = null;
        session()->flash('status', 'Grade updated successfully!');
    }

    public function closeModal()
    {
        $this->editEnrollmentId = null;
        $this->editMarks = null;
        $this->editStudentName = null;
    }

    public function render()
    {
        return view('livewire.teacher.section.grades');
    }
}
