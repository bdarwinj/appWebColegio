<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course; // Asegúrate de importar el modelo Course

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('course')->get();
        return view('students.index', compact('students'));
    }
    
    public function create()
    {
        // Obtener la lista de cursos para pasarla a la vista
        $courses = Course::all();
        return view('students.create', compact('courses'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'identificacion' => 'required|numeric|unique:students,identificacion',
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'course_id' => 'nullable|numeric',
            'representante' => 'nullable|string',
            'telefono' => 'nullable|string',
            'email' => 'nullable|email'
        ]);
        
        Student::create($request->all());
        return redirect()->route('students.index')->with('success', 'Estudiante registrado correctamente.');
    }
    
    public function show($id)
    {
        $student = Student::with('course')->findOrFail($id);
        return view('students.details', compact('student'));
    }
}
