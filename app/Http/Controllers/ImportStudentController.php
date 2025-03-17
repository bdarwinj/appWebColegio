<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Course;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportStudentController extends Controller
{
    public function showImportForm()
    {
        return view('students.import');
    }
    
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);
        
        $file = $request->file('excel_file');
        
        try {
            // Usar PhpSpreadsheet para obtener los nombres reales de las hojas
            $reader = IOFactory::createReaderForFile($file->getRealPath());
            $spreadsheet = $reader->load($file->getRealPath());
            $sheetNames = $spreadsheet->getSheetNames();
            
            // Convertir el archivo a una colección de hojas
            $sheets = Excel::toCollection(new \App\Imports\SheetCollectionImport(), $file);
        } catch (\Exception $e) {
            Log::error("Error al cargar el archivo Excel: " . $e->getMessage());
            return redirect()->back()->withErrors("Error al cargar el archivo Excel: " . $e->getMessage());
        }
        
        $importedCount = 0;
        $errors = [];
        
        // Obtener todos los cursos de la base de datos
        $courses = Course::all();
        
        // Procesar cada hoja del libro
        foreach ($sheets as $sheetIndex => $sheet) {
            // Obtener el nombre real de la hoja
            $sheetName = isset($sheetNames[$sheetIndex]) ? $sheetNames[$sheetIndex] : "Hoja " . ($sheetIndex + 1);
            $sheetNameNorm = $this->normalizeString($sheetName);
            
            // Determinar el curso a partir del nombre de la hoja
            if ($sheetNameNorm === "pre-jardin") {
                $baseSheet = "pre-jardin";
                $sectionSheet = "";
            } else {
                $parts = array_filter(array_map('trim', preg_split("/[-\s]+/", $sheetNameNorm)));
                $parts = array_values($parts);
                $baseSheet = $parts[0] ?? $sheetNameNorm;
                $sectionSheet = $parts[1] ?? "";
            }
            
            $courseData = null;
            foreach ($courses as $course) {
                $courseNameNorm = $this->normalizeString($course->name);
                $courseSectionNorm = $this->normalizeString($course->seccion);
                if ($courseNameNorm === $baseSheet) {
                    if ($sectionSheet) {
                        if ($courseSectionNorm === $sectionSheet) {
                            $courseData = $course;
                            break;
                        }
                    } else {
                        $courseData = $course;
                        break;
                    }
                }
            }
            if (!$courseData) {
                $errorMsg = "Hoja '{$sheetName}': Curso no encontrado en la base de datos.";
                $errors[] = $errorMsg;
                Log::warning($errorMsg);
                continue;
            }
            $courseId = $courseData->id;
            $currentYear = Carbon::now()->year;
            
            // Omitir la primera fila (encabezados)
            $rows = $sheet->skip(1);
            foreach ($rows as $rowIndex => $row) {
                try {
                    $rowArray = $row->toArray();
                    
                    // Validar que exista la columna "nombre"
                    if (!isset($rowArray['nombre']) && !isset($rowArray[0])) {
                        $errorMsg = "Hoja '{$sheetName}', fila " . ($rowIndex + 2) . ": Falta la columna 'nombre'.";
                        $errors[] = $errorMsg;
                        Log::warning($errorMsg);
                        continue;
                    }
                    
                    $nombreFull = isset($rowArray['nombre']) ? $rowArray['nombre'] : $rowArray[0];
                    if (!$nombreFull) {
                        $errorMsg = "Hoja '{$sheetName}', fila " . ($rowIndex + 2) . ": 'nombre' vacío.";
                        $errors[] = $errorMsg;
                        Log::warning($errorMsg);
                        continue;
                    }
                    $words = preg_split('/\s+/', $nombreFull);
                    if (count($words) < 4) {
                        $errorMsg = "Hoja '{$sheetName}', fila " . ($rowIndex + 2) . ": Valor en 'nombre' incorrecto: {$nombreFull}.";
                        $errors[] = $errorMsg;
                        Log::warning($errorMsg);
                        continue;
                    }
                    // Las dos primeras palabras serán el apellido y las dos siguientes el nombre.
                    $apellido = implode(' ', array_slice($words, 0, 2));
                    $nombre = implode(' ', array_slice($words, 2, 2));
                    
                    // Otros campos:
                    $identificacion = isset($rowArray['identificación']) ? trim($rowArray['identificación']) : (isset($rowArray[1]) ? trim($rowArray[1]) : "123456789");
                    if (!$identificacion) {
                        $identificacion = "123456789";
                    }
                    $telefono = isset($rowArray['telefono']) ? trim($rowArray['telefono']) : (isset($rowArray[2]) ? trim($rowArray[2]) : "");
                    $email = isset($rowArray['correo electronico']) ? trim($rowArray['correo electronico']) : (isset($rowArray[3]) ? trim($rowArray[3]) : "email@email.com");
                    $acudiente = isset($rowArray['acudiente']) ? trim($rowArray['acudiente']) : (isset($rowArray[4]) ? trim($rowArray[4]) : "");
                    
                    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errorMsg = "Hoja '{$sheetName}', fila " . ($rowIndex + 2) . ": Email inválido: {$email}.";
                        $errors[] = $errorMsg;
                        Log::warning($errorMsg);
                        continue;
                    }
                    
                    $student = Student::create([
                        'identificacion' => $identificacion,
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'course_id' => $courseId,
                        'representante' => $acudiente,
                        'telefono' => $telefono,
                        'email' => $email,
                        'active' => 1,
                    ]);
                    
                    Enrollment::create([
                        'student_id' => $student->id,
                        'course_id' => $courseId,
                        'academic_year' => $currentYear,
                        'status' => 'inscrito',
                        'date_enrolled' => Carbon::now(),
                    ]);
                    
                    $importedCount++;
                } catch (\Exception $e) {
                    $errorMsg = "Hoja '{$sheetName}', fila " . ($rowIndex + 2) . ": " . $e->getMessage();
                    $errors[] = $errorMsg;
                    Log::error($errorMsg);
                    continue;
                }
            }
        }
        
        $message = "Importados: {$importedCount} estudiantes.";
        if (count($errors) > 0) {
            $message .= " Algunos errores ocurrieron.";
        }
        return redirect()->route('students.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }
    
    private function normalizeString($string)
    {
        $normalized = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        return strtolower(trim($normalized));
    }
}
