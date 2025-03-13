<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'identificacion', 'nombre', 'apellido', 'course_id', 'representante', 'telefono', 'email', 'active'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    // Accessor para obtener el nombre completo del curso
    public function getCourseNameAttribute()
    {
        if ($this->course) {
            $parts = [$this->course->name];
            if (!empty($this->course->seccion)) {
                $parts[] = $this->course->seccion;
            }
            if (!empty($this->course->jornada)) {
                $parts[] = $this->course->jornada;
            }
            return implode(' - ', $parts);
        }
        return "N/A";
    }
}
