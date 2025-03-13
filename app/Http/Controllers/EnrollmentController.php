<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Carbon\Carbon;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'course'])->get();
        return view('enrollments.index', compact('enrollments'));
    }
    
    public function promote(Request $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $student = Student::findOrFail($enrollment->student_id);
        $currentCourse = Course::findOrFail($enrollment->course_id);
        
        // Suponemos que get_next_course es una función PHP que retorna el siguiente grado
        $nextGrade = get_next_course($currentCourse->name);
        if($nextGrade == $currentCourse->name){
            return redirect()->back()->withErrors("El estudiante ya está en el último curso.");
        }
        
        // Buscar curso del siguiente grado con la misma jornada
        $nextCourse = Course::where('name', $nextGrade)
            ->where('jornada', $currentCourse->jornada)
            ->first();
        if(!$nextCourse){
            return redirect()->back()->withErrors("No hay cursos disponibles para el siguiente grado con la misma jornada.");
        }
        
        $student->course_id = $nextCourse->id;
        $student->save();
        
        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $nextCourse->id,
            'academic_year' => Carbon::now()->year + 1,
            'status' => 'inscrito',
            'date_enrolled' => Carbon::now()
        ]);
        
        return redirect()->back()->with('success', 'Estudiante promovido y nueva inscripción creada.');
    }
}
