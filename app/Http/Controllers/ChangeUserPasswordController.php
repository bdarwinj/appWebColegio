<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangeUserPasswordController extends Controller
{
    /**
     * Retorna el formulario para que el admin cambie la contraseña de un usuario.
     */
    public function showForm($id)
    {
        $user = User::findOrFail($id);
        return view('auth.change_user_password', compact('user'));
    }
    
    /**
     * Procesa el cambio de contraseña para el usuario indicado.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed'
        ]);
        
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return redirect()->route('users.index')->with('success', 'Contraseña actualizada correctamente para el usuario.');
    }
}
