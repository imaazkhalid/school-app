<?php

use App\Http\Controllers\Admin\StudentResultCardController;
use App\Livewire\Admin\Courses\Index as AdminCourses;
use App\Livewire\Admin\Courses\Sections as AdminSections;
use App\Livewire\Admin\Courses\Students as AdminStudents;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Students\Index as AdminStudentsIndex;
use App\Livewire\Admin\Teachers\Index as AdminTeachersIndex;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Student\Dashboard as StudentDashboard;
use App\Livewire\Student\Enroll;
use App\Livewire\Teacher\Dashboard as TeacherDashboard;
use App\Livewire\Teacher\Section\Grades;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    try {
        // Check database connection
        DB::connection()->getPdo();

        // Check cache connection
        Cache::get('health');

        return response()->json(['status' => 'ok']);

    } catch (Exception $e) {
        // Log the full error for debugging
        Log::error('Health check failed', ['error' => $e->getMessage()]);

        return response()->json([
            'status' => 'error',
            'message' => 'Service unavailable',
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    if (auth()->user()->role === 'teacher') {
        return redirect()->route('teacher.dashboard');
    }
    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/courses', AdminCourses::class)->name('courses.index');
    Route::get('/courses/{course}/sections', AdminSections::class)->name('courses.sections.index');
    Route::get('/courses/{section}/students', AdminStudents::class)->name('courses.students.index');
    Route::get('/students', AdminStudentsIndex::class)->name('students.index');
    Route::get('/teachers', AdminTeachersIndex::class)->name('teachers.index');
    Route::get('/students/{student}/result-card', [StudentResultCardController::class, 'download'])->name('students.result-card');
});

Route::middleware(['auth', 'verified', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', TeacherDashboard::class)->name('dashboard');
    Route::get('/sections/{section}/grades', Grades::class)->name('sections.grades');
});

Route::middleware(['auth', 'verified', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', StudentDashboard::class)->name('dashboard');
    Route::get('/enroll', Enroll::class)->name('enrollment.index');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
