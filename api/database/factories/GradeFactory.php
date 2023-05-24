<?php

namespace Database\Factories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;


class GradeFactory extends Factory
{
    public function definition()
    {
        return [
            'designation' =>fake()->randomElement(['PA', 'PH', 'PES']),
        'charge_statutaire' =>fake()->numberBetween(1, 10),
        'taux_horaire_vacation' =>fake()->randomFloat(2, 10, 50),

        ];
    }
}
