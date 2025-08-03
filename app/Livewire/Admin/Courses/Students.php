<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use App\Models\Section;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Section Students')]
class Students extends Component
{
    public Section $section;

    public function mount(Section $section)
    {
        $this->section = $section;
    }

    public function render()
    {
        return view('livewire.admin.courses.students', [
            'students' => $this->section->students()->withPivot('grade')->get(),
        ]);
    }
}
