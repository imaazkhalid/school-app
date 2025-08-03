<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Courses')]
class Index extends Component
{
    use WithPagination;

    public $name = '';
    public $code = '';
    public $description = '';
    public bool $showCreateModal = false;
    public bool $showDeleteModal = false;

    public ?Course $editing = null;
    public ?Course $deleting = null;

    public function edit(Course $course)
    {
        $this->editing = $course;
        $this->name = $course->name;
        $this->code = $course->code;
        $this->description = $course->description;
        $this->showCreateModal = true;
    }

    public function destroy()
    {
        $this->deleting->delete();
        $this->deleting = null;
        $this->showDeleteModal = false;
    }

    public function delete(Course $course)
    {
        $this->deleting = $course;
        $this->showDeleteModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editing) {
            $this->editing->update([
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
            ]);
        } else {
            Course::create([
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
            ]);
        }

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'code', 'description', 'editing']);
        $this->resetValidation();
        $this->showCreateModal = false;
    }

    public function render()
    {
        return view('livewire.admin.courses.index', [
            'courses' => Course::withCount('sections')->latest()->paginate(10),
        ]);
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('courses')->ignore($this->editing),
            ],
            'description' => 'nullable|string',
        ];
    }
}
