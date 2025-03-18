<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;

class StudentController extends Controller
{
    public function index()
    {
        // Cargamos estudiantes con la relación course para el accessor course_name
        $students = Student::with('course')->get();
        // También obtenemos los cursos (para los modales, etc.)
        $courses = Course::all();
        return view('students.index', compact('students', 'courses'));
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
    
    public function details($id)
    {
        $student = Student::with('course')->findOrFail($id);
        // Suponiendo que tengas una relación payments en el modelo Student
        $payments = $student->payments()->orderBy('payment_date', 'desc')->get();
        return view('students.details_modal', compact('student', 'payments'));
    }
    // Método para retornar el historial de inscripciones de un estudiante (para modal)
    public function enrollmentHistory($id)
    {
        $student = Student::with(['enrollments.course'])->findOrFail($id);
        return view('students.enrollment_history_modal', compact('student'));
    }
    
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $courses = Course::all();
        return view('students.edit', compact('student', 'courses'));
    }
    
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'course_id' => 'nullable|numeric',
            'representante' => 'nullable|string',
            'telefono' => 'nullable|string',
            'email' => 'nullable|email'
        ]);
        $data = $request->all();
        $data['updated_by'] = auth()->id(); // Registrar el usuario que actualiza
        $student->update($data);
        return redirect()->route('students.index')->with('success', 'Estudiante actualizado correctamente.');
    }
}
