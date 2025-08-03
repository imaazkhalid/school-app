<?php

namespace App\Livewire\Student;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        /** @var User $user */
        $user = auth()->user();
        $student = $user->student;
        $sections = $student->sections()->with(['course', 'teacher.user'])->withPivot('grade')->get();

        return view('livewire.student.dashboard', [
            'sections' => $sections,
        ]);
    }
}
