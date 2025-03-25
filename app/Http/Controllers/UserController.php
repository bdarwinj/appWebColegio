<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
    // Método para eliminar un usuario
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            // Evitar que el admin se borre a sí mismo
            if (auth()->id() == $user->id) {
                return redirect()->route('users.index')->withErrors("No puedes eliminar tu propio usuario.");
            }
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al eliminar usuario: " . $e->getMessage());
            return redirect()->route('users.index')->withErrors("Error al eliminar usuario.");
        }
    }
}
