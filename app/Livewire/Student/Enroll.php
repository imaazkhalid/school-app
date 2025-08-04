<?php

namespace App\Livewire\Student;

use App\Models\Section;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Enroll in Courses')]
class Enroll extends Component
{
    use WithPagination;

    public Section $section;

    public bool $isConfirmingEnrollment = false;
    public ?Section $sectionToEnroll = null;

    public function confirmEnrollment(Section $section)
    {
        $this->isConfirmingEnrollment = true;
        $this->sectionToEnroll = $section;
    }

    public function enroll()
    {
        $section = $this->sectionToEnroll;

        if (!$section) {
            session()->flash('error', 'No section selected for enrollment.');
            $this->isConfirmingEnrollment = false;
            return;
        }

        /** @var User $user */
        $user = auth()->user();
        $student = $user->student;

        // Acquire an atomic lock for this specific section to prevent race conditions.
        $lock = Cache::lock('section-enrollment:' . $section->id, 10);

        if ($lock->get()) {
            try {
                // Begin a database transaction.
                DB::transaction(function () use ($section, $student) {

                    // Reload the section with a row-level lock to ensure its state is fresh and can't be changed.
                    $section = $section->lockForUpdate()->find($section->id);

                    // Check if there are still seats available.
                    if ($section->seats_available <= 0) {
                        throw new \Exception('This section is full.');
                    }

                    // Check if the student is already enrolled.
                    if ($section->students()->wherePivot('student_id', $student->id)->exists()) {
                        throw new \Exception('You are already enrolled in this section.');
                    }

                    // Decrement the available seats.
                    $section->decrement('seats_available');

                    // Create the enrollment record.
                    $section->students()->attach($student->id, [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                });

                session()->flash('status', 'You have been successfully enrolled!');
            } catch (\Exception $e) {
                session()->flash('error', $e->getMessage());
            } finally {
                // Release the lock, whether the transaction succeeded or failed.
                $lock->release();
            }
        } else {
            session()->flash('error', 'The system is busy, please try enrolling again in a moment.');
        }

        $this->isConfirmingEnrollment = false;
        $this->sectionToEnroll = null;
    }

    public function render()
    {
        $availableSections = Section::where('seats_available', '>', 0)
            ->with(['course', 'teacher.user'])
            ->paginate(10);

        return view('livewire.student.enroll', [
            'availableSections' => $availableSections,
        ]);
    }
}
