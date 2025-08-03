<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'courseCount' => Course::count(),
            'studentCount' => Student::count(),
            'teacherCount' => Teacher::count(),
        ]);
    }
}
