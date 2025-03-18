<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

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
}
