<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

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
        
        Course::create($request->only('name', 'seccion', 'jornada'));
        return redirect()->route('courses.index')->with('success', 'Curso agregado correctamente.');
    }
}
