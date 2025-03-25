<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Enrollment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCourses = Course::count();
        $totalStudents = Student::count();
        $coursesWithStudents = Student::whereNotNull('course_id')->distinct()->count('course_id');
        $students = Student::with('course')->get();
        
        $courseCount = $students->groupBy(function($student) {
            return $student->course 
                ? $student->course->name . ' - ' . $student->course->seccion . ($student->course->jornada ? ' - ' . $student->course->jornada : '')
                : 'N/A';
        })->map->count();
        
        $currentMonth = Carbon::now()->format('Y-m');
        $currentYear = Carbon::now()->year;
        $paymentsMonth = Payment::whereRaw("DATE_FORMAT(payment_date, '%Y-%m') = ?", [$currentMonth])->get();
        $totalMonth = $paymentsMonth->sum('amount');
        $paymentsYear = Payment::whereRaw("YEAR(payment_date) = ?", [$currentYear])->get();
        $totalYear = $paymentsYear->sum('amount');
        
        $studentsPaidIds = $paymentsMonth->pluck('student_id')->unique();
        $studentsWithoutPayment = Student::whereNotIn('id', $studentsPaidIds)->get();
        $courses = Course::withCount('students')->get(); // Obtiene cursos con cantidad de alumnos
        
        return view('dashboard', compact('totalCourses', 'coursesWithStudents', 'totalStudents', 'courseCount', 'totalMonth', 'totalYear', 'studentsWithoutPayment', 'currentMonth', 'currentYear','courses'));
    }
}
