<?php

namespace App\Livewire\Teacher\Section;

use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Manage Grades')]
class Grades extends Component
{
    public Section $section;

    #[Validate([
        'grades.*' => 'nullable|numeric|min:0|max:100',
    ])]
    public array $grades = [];

    public function mount(Section $section)
    {
        Gate::authorize('update', $section);

        $this->section = $section;
        $this->loadGrades();
    }

    public function loadGrades(): void
    {
        $this->grades = $this->section->students->pluck('pivot.grade', 'id')->toArray();
    }

    public function saveGrades(): void
    {
        $this->validate();

        DB::transaction(function () {
            foreach ($this->grades as $studentId => $grade) {
                $this->section->students()->updateExistingPivot($studentId, ['grade' => $grade]);
            }
        });

        session()->flash('status', 'Grades saved successfully!');
    }

    public function render()
    {
        return view('livewire.teacher.section.grades', [
            'students' => $this->section->students()->withPivot('grade')->get(),
        ]);
    }
}
