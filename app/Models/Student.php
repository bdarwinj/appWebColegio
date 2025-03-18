<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Student extends Model
{
    protected $fillable = [
        'identificacion', 
        'nombre', 
        'apellido', 
        'course_id', 
        'representante', 
        'telefono', 
        'email', 
        'active', 
        'updated_by'
    ];

    /**
     * Relación con el curso al que pertenece el estudiante.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relación con las inscripciones del estudiante.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Relación con los pagos realizados por el estudiante.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Relación con el usuario que actualizó el registro del estudiante.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Accessor para obtener el nombre completo del curso, incluyendo sección y jornada.
     */
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
