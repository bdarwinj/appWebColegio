<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseFee;
use App\Models\Course;
use App\Models\Student;
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
     * Renderiza la vista de estado de cuenta y calcula el resumen global.
     */
    public function status(Request $request)
    {
        $academicYear = $request->input('academic_year', date('Y'));
        $students = Student::with('course')->get();
        $globalBalance = 0;
        $globalPendingMonths = 0;
        
        // Se recorre cada estudiante para calcular el balance (aunque la tabla se cargará por AJAX)
        foreach ($students as $student) {
            $balanceData = calculate_student_balance($student->id, $academicYear);
            if ($balanceData && $balanceData['balance'] > 0) {
                $globalBalance += $balanceData['balance'];
                $globalPendingMonths += $balanceData['pending_months'];
            }
        }
        
        return view('course_fees.status', compact('academicYear', 'globalBalance', 'globalPendingMonths'));
    }
    
    /**
     * Método AJAX que retorna en formato JSON el listado de estudiantes en mora.
     */
    public function statusAjax(Request $request)
    {
        $academicYear = $request->input('academic_year', date('Y'));
        $students = Student::with('course')->get();
        $data = [];
        foreach ($students as $student) {
            $balanceData = calculate_student_balance($student->id, $academicYear);
            if ($balanceData && $balanceData['balance'] > 0) {
                $data[] = [
                    'id'               => $student->id,
                    'identificacion'   => $student->identificacion,
                    'nombre'           => $student->nombre . ' ' . $student->apellido,
                    'course'           => $student->course ? ($student->course->name .
                                            ($student->course->seccion ? ' - ' . $student->course->seccion : '') .
                                            ($student->course->jornada ? ' - ' . $student->course->jornada : '')) : 'N/A',
                    'monthly_fee'      => number_format($balanceData['monthly_fee'], 2),
                    'expected_total'   => number_format($balanceData['expected_total'], 2),
                    'total_paid'       => number_format($balanceData['total_paid'], 2),
                    'balance'          => number_format($balanceData['balance'], 2),
                    'pending_months'   => $balanceData['pending_months']
                ];
            }
        }
        return response()->json(['data' => $data]);
    }
}
