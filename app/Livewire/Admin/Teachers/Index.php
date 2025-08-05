<?php

namespace App\Livewire\Admin\Teachers;

use App\Models\Teacher;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('All Teachers')]
class Index extends Component
{
    use WithPagination;

    public $showCreateModal = false;
    public $selectedUserId;

    public function render()
    {
        return view('livewire.admin.teachers.index', [
            'teachers' => Teacher::with('user')->paginate(15),
            'users' => User::where('role', '!=', 'teacher')->get(),
        ]);
    }

    public function createTeacher()
    {
        $user = User::find($this->selectedUserId);
        if ($user && !$user->teacher) {
            $user->role = 'teacher';
            $user->save();
            $user->teacher()->create([
                'teacher_id' => uniqid('TCH-'),
            ]);
            session()->flash('status', 'Teacher created successfully!');
        }
        $this->showCreateModal = false;
    }
}
