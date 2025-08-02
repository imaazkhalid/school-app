<?php

namespace App\Livewire\Admin\Course;

use App\Models\Course;
use App\Models\Teacher;
use Livewire\Component;

class Sections extends Component
{
    public Course $course;
    public string $name = '';
    public int $teacher_id = 0;
    public string $schedule = '';
    public int $capacity = 30;
    public bool $showCreateModal = false;

    public function mount(Course $course)
    {
        $this->course = $course;
    }

    public function save()
    {
        $this->validate();

        $this->course->sections()->create([
            'name' => $this->name,
            'teacher_id' => $this->teacher_id,
            'schedule' => $this->schedule,
            'capacity' => $this->capacity,
            'seats_available' => $this->capacity,
        ]);

        $this->reset(['name', 'teacher_id', 'schedule', 'capacity']);
        $this->showCreateModal = false;
    }

    public function resetForm()
    {
        $this->reset(['name', 'teacher_id', 'schedule', 'capacity']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.course.sections', [
            'sections' => $this->course->sections()->with('teacher.user')->latest()->get(),
            'teachers' => Teacher::with('user')->get(),
        ]);
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:sections,name,NULL,id,course_id,' . $this->course->id,
            'teacher_id' => 'required|exists:teachers,id',
            'schedule' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1|max:999',
        ];
    }
}
