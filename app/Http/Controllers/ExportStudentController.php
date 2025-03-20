<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Models\Student;

class ExportStudentController extends Controller
{
    /**
     * Exporta el listado de estudiantes a PDF en orientación horizontal.
     */
    public function exportPdf()
    {
        $students = Student::with('course')->get();
        $pdf = PDF::loadView('students.export_pdf', compact('students'))
                  ->setPaper('a4', 'landscape'); // Configura orientación apaisada
        return $pdf->download('estudiantes_' . date('Ymd_His') . '.pdf');
    }
    
    /**
     * Exporta el listado de estudiantes a Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new StudentsExport, 'estudiantes_' . date('Ymd_His') . '.xlsx');
    }
}
