<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Course Sections')]
class Sections extends Component
{
    public Course $course;
    public string $name = '';
    public int $teacher_id = 0;
    public string $schedule = '';
    public int $capacity = 30;
    public bool $showCreateModal = false;
    public bool $showDeleteModal = false;

    public ?Section $editing = null;
    public ?Section $deleting = null;

    public function mount(Course $course)
    {
        $this->course = $course;
    }

    public function edit(Section $section)
    {
        $this->editing = $section;
        $this->name = $section->name;
        $this->teacher_id = $section->teacher_id;
        $this->schedule = $section->schedule;
        $this->capacity = $section->capacity;

        $this->showCreateModal = true;
    }

    public function destroy()
    {
        $this->deleting->delete();
        $this->deleting = null;
        $this->showDeleteModal = false;
    }

    public function delete(Section $section)
    {
        $this->deleting = $section;
        $this->showDeleteModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editing) {
            $this->editing->update([
                'name' => $this->name,
                'teacher_id' => $this->teacher_id,
                'schedule' => $this->schedule,
                'capacity' => $this->capacity,
                'seats_available' => $this->capacity,
            ]);
        } else {
            $this->course->sections()->create([
                'name' => $this->name,
                'teacher_id' => $this->teacher_id,
                'schedule' => $this->schedule,
                'capacity' => $this->capacity,
                'seats_available' => $this->capacity,
            ]);
        }

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
        return view('livewire.admin.courses.sections', [
            'sections' => $this->course->sections()->with('teacher.user')->latest()->get(),
            'teachers' => Teacher::with('user')->get(),
        ]);
    }

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sections')
                    ->ignore($this->editing)
                    ->where(fn($query) => $query->where('course_id', $this->course->id))
            ],
            'teacher_id' => 'required|exists:teachers,id',
            'schedule' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1|max:999',
        ];
    }
}
