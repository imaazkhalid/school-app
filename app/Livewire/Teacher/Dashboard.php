<?php

namespace App\Livewire\Teacher;

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
        $teacher = $user->teacher;
        $sections = $teacher->sections()->with('course')->withCount('students')->get();

        return view('livewire.teacher.dashboard', [
            'sections' => $sections,
        ]);
    }
}
