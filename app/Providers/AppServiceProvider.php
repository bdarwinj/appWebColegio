<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Se intenta obtener el nombre del colegio y la ruta del logo desde la tabla config.
        // Se usa un valor por defecto si no se encuentra.
        $schoolName = DB::table('config')->where('key', 'SCHOOL_NAME')->value('value') ?? 'Colegio Ejemplo';
        $logoPath = DB::table('config')->where('key', 'LOGO_PATH')->value('value') ?? '';

        // Compartir estas variables en todas las vistas.
        View::share('schoolName', $schoolName);
        View::share('logoPath', $logoPath);
    }
}
