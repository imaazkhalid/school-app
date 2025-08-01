<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use Livewire\Component;

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
