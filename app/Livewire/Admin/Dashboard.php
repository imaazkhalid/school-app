<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Admin Dashboard')]
class Dashboard extends Component
{
    public $courses;

    public $name = '';
    public $code = '';
    public $description = '';
    public bool $showCreateModal = false;

    public function mount()
    {
        $this->getCourses();
    }

    #[On('course-created')]
    public function getCourses()
    {
        $this->courses = Course::withCount('sections')->get()->sortByDesc('created_at');
    }

    public function save()
    {
        $this->validate();

        Course::create([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
        ]);

        // Reset the form fields and close the modal
        $this->reset(['name', 'code', 'description']);
        $this->showCreateModal = false;

        // Dispatch an event to refresh the course list
        $this->getCourses();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:courses,code',
            'description' => 'nullable|string',
        ];
    }
}
