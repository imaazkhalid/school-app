<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'code', 'description'];

    /**
     * The sections for this course.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }
}
