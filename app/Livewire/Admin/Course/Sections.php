<?php

namespace App\Livewire\Admin\Course;

use App\Models\Course;
use Livewire\Component;

class Sections extends Component
{
    public Course $course;

    public function mount(Course $course)
    {
        $this->course = $course;
    }

    public function render()
    {
        return view('livewire.admin.course.sections', [
            'sections' => $this->course->sections()->get(),
        ]);
    }
}
