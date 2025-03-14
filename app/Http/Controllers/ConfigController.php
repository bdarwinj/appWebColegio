<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{
    public function edit()
    {
        // Obtener las configuraciones desde la tabla 'config'
        $configs = DB::table('config')->pluck('value', 'key')->toArray();
        return view('config.edit', compact('configs'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'SCHOOL_NAME' => 'required|string',
            'logo' => 'nullable|image|max:2048' // Máximo 2MB
        ]);

        // Actualizar el nombre del colegio
        DB::table('config')->updateOrInsert(['key' => 'SCHOOL_NAME'], ['value' => $request->SCHOOL_NAME]);

        // Si se sube un logo, procesarlo
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo.' . $file->getClientOriginalExtension();
            // Guardar el archivo en public/assets
            $path = $file->storeAs('assets', $filename, 'public');
            DB::table('config')->updateOrInsert(['key' => 'LOGO_PATH'], ['value' => $path]);
        }

        return redirect()->route('config.edit')->with('success', 'Configuración actualizada correctamente.');
    }
}
