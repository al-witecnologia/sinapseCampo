<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registro>
 */
class RegistroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'tag'                   =>  fake()->ean8(),
            'valor'                 =>  fake()->randomFloat(2,18,40),
            'tipo'                  =>  1,
            'data_hora'             =>  fake()->dateTimeThisMonth(),            
        ];
    }
}
