<?php

namespace App\Livewire\Admin\Students;

use App\Models\Student;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('All Students')]
class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.students.index', [
            'students' => Student::with('user')->paginate(15),
        ]);
    }
}
