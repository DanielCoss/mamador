<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empleado = new Empleado();
        $empleado->clave = 293888;
        $empleado->nombre = " Vallejo Coss Josue Daniel";
        $empleado->departamento = 'Edifico T';
        $empleado->puesto = 'Becario';
        $empleado->sueldo = 2000.23;

        $empleado->save();
        $empleado = new Empleado();
        $empleado->clave = 293889;
        $empleado->nombre = "Vallejo Lopez Raul Segio";
        $empleado->departamento = 'Edifico A';
        $empleado->puesto = 'Becario';
        $empleado->sueldo = 2000.23;

        $empleado->save();
    }
}
