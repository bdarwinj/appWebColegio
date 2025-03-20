<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CourseStudentsSheet implements FromCollection, WithMapping, WithHeadings, WithEvents
{
    protected $students;
    protected $courseName;

    public function __construct(Collection $students, $courseName)
    {
        $this->students = $students;
        $this->courseName = $courseName;
    }

    public function collection()
    {
        return $this->students;
    }

    public function map($student): array
    {
        $course = $student->course;
        $courseName = $course ? $course->name : '';
        if ($course && $course->seccion) {
            $courseName .= ' - ' . $course->seccion;
        }
        if ($course && $course->jornada) {
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Ajustar automáticamente el ancho de las columnas de A a H
                foreach (range('A', 'H') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
                
                // Establecer estilo a los encabezados
                $headerRange = 'A1:H1';
                $sheet->getStyle($headerRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF003366'); // Fondo azul oscuro
                $sheet->getStyle($headerRange)->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // Texto blanco
                // Puedes ajustar más estilos según prefieras
            },
        ];
    }
}
