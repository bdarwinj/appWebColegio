<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EnrollmentController extends Controller
{
    /**
     * Muestra el listado de inscripciones (opcional).
     */
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'course'])->orderBy('academic_year', 'desc')->get();
        return view('enrollments.index', compact('enrollments'));
    }
    
    /**
     * Obtiene una inscripción por su ID.
     *
     * @param int $enrollmentId
     * @return Enrollment|null
     */
    public function getEnrollmentById($enrollmentId): ?\App\Models\Enrollment
    {
        return Enrollment::where('id', $enrollmentId)->first();
    }
    
    /**
     * Actualiza el estado de una inscripción.
     *
     * @param int $enrollmentId
     * @param string $status
     * @return array [bool, string]
     */
    public function updateEnrollmentStatus($enrollmentId, $status)
    {
        $enrollment = Enrollment::find($enrollmentId);
        if (!$enrollment) {
            return [false, "Inscripción no encontrada."];
        }
        $enrollment->status = $status;
        $enrollment->save();
        return [true, "Estado actualizado correctamente."];
    }
    
    /**
     * Crea una nueva inscripción.
     *
     * @param int $studentId
     * @param int $courseId
     * @param int $academicYear
     * @param string $status
     * @return array [bool, string, int|null]
     */
    public function createEnrollment($studentId, $courseId, $academicYear, $status = "inscrito")
    {
        try {
            $enrollment = Enrollment::create([
                'student_id' => $studentId,
                'course_id' => $courseId,
                'academic_year' => $academicYear,
                'status' => $status,
                'date_enrolled' => Carbon::now()
            ]);
            return [true, "Inscripción creada correctamente.", $enrollment->id];
        } catch (\Exception $e) {
            Log::error("Error al crear inscripción: " . $e->getMessage());
            return [false, "Error al crear inscripción: " . $e->getMessage(), null];
        }
    }
    
    /**
     * Promueve al estudiante asociado a una inscripción.
     *
     * @param int $enrollmentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function promote($enrollmentId)
    {
        try {
            $enrollment = $this->getEnrollmentById($enrollmentId);
            if (!$enrollment) {
                return redirect()->back()->withErrors("Inscripción no encontrada.");
            }
            
            $studentId = $enrollment->student_id;
            $currentCourseId = $enrollment->course_id;
            $currentCourse = Course::find($currentCourseId);
            if (!$currentCourse) {
                return redirect()->back()->withErrors("Curso actual no encontrado.");
            }
            
            $currentGrade = $currentCourse->name;
            $currentJornada = $currentCourse->jornada ?? "";
            $nextGrade = get_next_course($currentGrade);
            if (strtolower($nextGrade) == strtolower($currentGrade)) {
                return redirect()->back()->withErrors("El estudiante ya está en el último curso.");
            }
            
            // Obtener cursos del siguiente grado con la misma jornada
            $allNextCourses = Course::where('name', $nextGrade)
                                ->where('active', 1)
                                ->get();
            $nextCourses = $allNextCourses->filter(function($course) use ($currentJornada) {
                return trim(strtolower($course->jornada)) === trim(strtolower($currentJornada));
            });
            if ($nextCourses->isEmpty()) {
                return redirect()->back()->withErrors("No hay cursos disponibles para el grado {$nextGrade} con la misma jornada.");
            }
            $nextCourse = $nextCourses->first();
            $nextCourseId = $nextCourse->id;
            
            // Actualizar el curso del estudiante
            $student = Student::find($studentId);
            if (!$student) {
                return redirect()->back()->withErrors("Estudiante no encontrado.");
            }
            $student->course_id = $nextCourseId;
            $student->save();
            
            $nextYear = $enrollment->academic_year + 1;
            list($enrollSuccess, $enrollMsg, $newEnrollmentId) = $this->createEnrollment($studentId, $nextCourseId, $nextYear, "inscrito");
            if ($enrollSuccess) {
                return redirect()->back()->with('success', "Estudiante promovido y nueva inscripción creada.");
            }
            return redirect()->back()->withErrors($enrollMsg);
        } catch (\Exception $e) {
            Log::error("Error al promover al estudiante: " . $e->getMessage());
            return redirect()->back()->withErrors("Error al promover al estudiante: " . $e->getMessage());
        }
    }
    
    /**
     * Retorna el historial de inscripciones de un estudiante.
     *
     * @param int $studentId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEnrollmentHistory($studentId)
    {
        return Enrollment::where('student_id', $studentId)->orderBy('academic_year', 'desc')->get();
    }
}
