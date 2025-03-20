<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseFee;
use App\Models\Course;
use Carbon\Carbon;

class CourseFeeController extends Controller
{
    public function config()
    {
        $currentYear = Carbon::now()->year;
        $courseFees = CourseFee::where('academic_year', $currentYear)->with('course')->get();
        $courses = Course::all();
        return view('course_fees.config', compact('courseFees', 'courses', 'currentYear'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|numeric|exists:courses,id',
            'academic_year' => 'required|numeric',
            'fee' => 'required|numeric|min:0'
        ]);
        
        CourseFee::updateOrCreate(
            [
                'course_id' => $request->course_id,
                'academic_year' => $request->academic_year
            ],
            ['fee' => $request->fee]
        );
        
        return redirect()->route('course_fees.config')->with('success', 'Tarifa actualizada correctamente.');
    }
    
    /**
     * Muestra el estado de cuenta de mensualidades de los estudiantes en mora.
     *
     * Filtra a los estudiantes cuyo balance pendiente es mayor que cero y calcula
     * el total global adeudado y la suma de meses pendientes.
     */
    public function status(Request $request)
    {
        $academicYear = $request->input('academic_year', date('Y'));
        $students = \App\Models\Student::with('course')->get();
        $studentsInMora = [];
        $globalBalance = 0;
        $globalPendingMonths = 0;
        
        foreach ($students as $student) {
            $balanceData = calculate_student_balance($student->id, $academicYear);
            if ($balanceData && $balanceData['balance'] > 0) {
                // Adjuntar la información de balance al estudiante
                $student->setAttribute('balanceData', $balanceData);
                $studentsInMora[] = $student;
                $globalBalance += $balanceData['balance'];
                $globalPendingMonths += $balanceData['pending_months'];
            }
        }
        
        return view('course_fees.status', compact('studentsInMora', 'academicYear', 'globalBalance', 'globalPendingMonths'));
    }
}
