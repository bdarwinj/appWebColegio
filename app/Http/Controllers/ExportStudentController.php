<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\StudentsMultipleSheetsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Student;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;

class ExportStudentController extends Controller
{
    /**
     * Exporta el listado de estudiantes a PDF en orientación apaisada.
     */
    public function exportPdf()
    {
        // Obtener los estudiantes con sus cursos relacionados
        $students = Student::with('course')->get();
        
        // Obtener las configuraciones del colegio desde la base de datos
        $configs = DB::table('config')->pluck('value', 'key')->toArray();
        
        // Definir el logo y el nombre del colegio usando las configuraciones o valores por defecto
        $logoPath = $configs['LOGO_PATH'] ?? 'logos/colegio.png'; // Ruta relativa a public/storage
        $schoolName = $configs['SCHOOL_NAME'] ?? 'Nombre del Colegio';

        // Renderizar la vista con los datos necesarios
        $html = view('students.export_pdf', compact('students', 'logoPath', 'schoolName'))->render();

        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Para permitir imágenes externas si aplica

        // Crear instancia de Dompdf
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Agregar número de página dinámicamente
        $canvas = $dompdf->getCanvas();
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Página $pageNumber de $pageCount";
            $font = $fontMetrics->getFont('Arial', 'normal');
            $size = 10;
            $width = $fontMetrics->getTextWidth($text, $font, $size);
            $canvas->text(750 - $width, 550, $text, $font, $size); // Coordenadas para A4 landscape
        });

        // Descargar el PDF
        return $dompdf->stream('estudiantes_' . date('Ymd_His') . '.pdf');
    }

    // El método exportExcel permanece sin cambios
    public function exportExcel()
    {
        return Excel::download(new StudentsMultipleSheetsExport, 'estudiantes_' . date('Ymd_His') . '.xlsx');
    }
}