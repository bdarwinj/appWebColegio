<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
    
    public function create()
    {
        return view('users.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string',
            'role' => 'required|string'
        ]);
        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }
}
