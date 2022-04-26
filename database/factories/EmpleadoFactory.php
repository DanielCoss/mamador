<?php

namespace Database\Factories;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpleadoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Empleado::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'clave' => $this->faker->numer(),
            'nombre' => $this->faker->word(),
            'apellidoP' => $this->faker->word(),
            'apellidoM' => $this->faker->word(),
            'nombre' => $this->faker->word(),
            'departamento' => $this->faker->word(),
            'puesto' => $this->faker->word(),
            'sueldo' => $this->faker->number()
        ];
    }
}
