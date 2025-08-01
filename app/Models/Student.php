<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'student_id'];

    /**
     * Get the user that owns the student profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The sections that the student is enrolled in.
     * The withPivot() method allows us to access the 'grade' column from the enrollments table.
     */
    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class, 'enrollments')->withPivot('grade');
    }
}
