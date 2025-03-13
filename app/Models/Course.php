<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'seccion', 'jornada', 'active'
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function courseFee()
    {
        return $this->hasOne(CourseFee::class);
    }
}
