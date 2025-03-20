<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseFee extends Model
{
    protected $fillable = [
        'course_id',
        'academic_year',
        'fee'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
