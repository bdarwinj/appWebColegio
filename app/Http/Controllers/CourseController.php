<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Student;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }
    
    public function create()
    {
        return view('courses.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'seccion' => 'nullable|string',
            'jornada' => 'nullable|string'
        ]);
        
        $data = $request->only('name', 'seccion', 'jornada');
        $data['jornada'] = $data['jornada'] ?? "";
        Course::create($data);
        return redirect()->route('courses.index')->with('success', 'Curso agregado correctamente.');
    }
    
    /**
     * Retorna los cursos que coinciden con el grado especificado.
     *
     * @param string $grade
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCoursesByGrade($grade)
    {
        return Course::where('name', $grade)->where('active', 1)->get();
    }
/**
     * Muestra la lista de estudiantes de un curso específico.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function students($id)
    {
        $course = Course::with('students')->findOrFail($id);
        return view('courses.students', compact('course'));
    }
    /**
     * Retorna el formulario de edición para el curso.
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    /**
     * Actualiza el curso.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'seccion' => 'nullable|string',
            'jornada' => 'nullable|string',
            'active' => 'required|boolean'
        ]);

        // Recoger los datos y forzar que 'jornada' nunca sea null
        $data = $request->only(['name', 'seccion', 'jornada', 'active']);
        $data['jornada'] = $data['jornada'] ?? "";

        $course = Course::findOrFail($id);
        $course->update($data);

        return redirect()->route('courses.index')->with('success', 'Curso actualizado correctamente.');
    }
}
