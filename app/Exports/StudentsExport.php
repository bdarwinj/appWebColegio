<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Cargar estudiantes junto a su curso (relación)
        return Student::with('course')->get();
    }

    public function headings(): array
    {
        return [
            'Identificación',
            'Nombre',
            'Apellido',
            'Curso',
            'Representante',
            'Teléfono',
            'Email',
            'Estado'
        ];
    }

    public function map($student): array
    {
        $course = $student->course;
        $courseName = $course ? $course->name : '';
        if($course && $course->seccion) {
            $courseName .= ' - ' . $course->seccion;
        }
        if($course && $course->jornada) {
            $courseName .= ' - ' . $course->jornada;
        }
        return [
            $student->identificacion,
            $student->nombre,
            $student->apellido,
            $courseName,
            $student->representante,
            $student->telefono,
            $student->email,
            $student->active ? 'Activo' : 'Inactivo'
        ];
    }
}
