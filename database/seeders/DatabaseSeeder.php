<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Llama al seeder del admin.
        $this->call(AdminSeeder::class);
        // Puedes llamar a otros seeders aquí si es necesario.
    }
}
