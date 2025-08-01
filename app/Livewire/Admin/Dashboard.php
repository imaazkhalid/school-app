<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Admin Dashboard')]
class Dashboard extends Component
{
    public $courses;

    public function mount()
    {
        $this->courses = Course::withCount('sections')->get();
    }
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
