<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\Student;
use Illuminate\Support\Collection;

class StudentsMultipleSheetsExport implements WithMultipleSheets
{
    protected $allStudents;

    public function __construct()
    {
        // Cargar estudiantes con su curso relacionado
        $this->allStudents = Student::with('course')->get();
    }

    public function sheets(): array
    {
        $sheets = [];
        // Agrupar estudiantes por el nombre del curso (si no tienen curso, se agrupan en 'Sin Curso')
        $grouped = $this->allStudents->groupBy(function($student) {
            return $student->course ? $student->course->name : 'Sin Curso';
        });
        
        // Crear una hoja para cada curso
        foreach ($grouped as $courseName => $students) {
            $sheets[] = new CourseStudentsSheet($students, $courseName);
        }
        
        // Agregar una hoja final con todos los estudiantes
        $sheets[] = new CourseStudentsSheet($this->allStudents, 'Todos');
        
        return $sheets;
    }
}
