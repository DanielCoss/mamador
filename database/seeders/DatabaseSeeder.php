<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(EmpleadoSeeder::class);
        $this->call(AsistenciaMensualSeeder::class);
        $this->call(AsistenciaDiariaSeeder::class);
        $this->call(HorarioClasesSeeder::class);
        $this->call(HorarioSeeder::class);
    }
}
