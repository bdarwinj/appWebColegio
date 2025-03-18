<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'academic_year',
        'status',
        'date_enrolled'
    ];

    /**
     * Relación con el estudiante.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relación con el curso.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
