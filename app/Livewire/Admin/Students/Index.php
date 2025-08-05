<?php

namespace App\Livewire\Admin\Students;

use App\Models\Student;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('All Students')]
class Index extends Component
{
    use WithPagination;

    public $showDetailsModal = false;
    public $selectedStudent = null;

    public function showDetails($studentId)
    {
        $this->selectedStudent = Student::with([
            'user',
            'enrollments.section.course'
        ])->find($studentId);
        $this->showDetailsModal = true;
    }

    public function generateResultCard()
    {
        // Implement result card logic (PDF, download, etc.)
        session()->flash('status', 'Result card generated (stub).');
    }

    public function render()
    {
        return view('livewire.admin.students.index', [
            'students' => Student::with('user')->paginate(15),
        ]);
    }
}
