<?php

use App\Livewire\Admin\Courses\Index as AdminCourses;
use App\Livewire\Admin\Courses\Sections as AdminSections;
use App\Livewire\Admin\Courses\Students as AdminStudents;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Student\Dashboard as StudentDashboard;
use App\Livewire\Teacher\Dashboard as TeacherDashboard;
use Illuminate\Support\Facades\Route;

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
    Route::get('/courses/{course}/students', AdminStudents::class)->name('courses.students.index');
});

Route::middleware(['auth', 'verified', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', TeacherDashboard::class)->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', StudentDashboard::class)->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
