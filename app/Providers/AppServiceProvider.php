<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if (Schema::hasTable('config')) {
            $schoolName = DB::table('config')->where('key', 'SCHOOL_NAME')->value('value') ?? 'Colegio Ejemplo';
            $logoPath = DB::table('config')->where('key', 'LOGO_PATH')->value('value') ?? '';

            // Compartir estas variables en todas las vistas.
            View::share('schoolName', $schoolName);
            View::share('logoPath', $logoPath);
        }
    }
}
