<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseFee;

class CourseFeeController extends Controller
{
    /**
     * Muestra la vista de configuración de tarifas.
     */
    public function config()
    {
        // Obtener todos los cursos para llenar el select
        $courses = Course::all();
        // Obtener todas las tarifas configuradas (con la relación con el curso)
        $courseFees = CourseFee::with('course')->get();
        return view('course_fees.config', compact('courses', 'courseFees'));
    }

    /**
     * Guarda o actualiza la tarifa de un curso para un año académico.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|numeric',
            'academic_year' => 'required|numeric',
            'fee' => 'required|numeric|min:0'
        ]);

        // Buscar si ya existe una tarifa para este curso y año
        $courseFee = CourseFee::firstOrNew([
            'course_id' => $request->course_id,
            'academic_year' => $request->academic_year
        ]);
        $courseFee->fee = $request->fee;
        $courseFee->save();

        return redirect()->route('course_fees.config')->with('success', 'Tarifa actualizada correctamente.');
    }
}
