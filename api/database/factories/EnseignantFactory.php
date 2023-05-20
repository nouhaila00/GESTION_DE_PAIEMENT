<?php

namespace Database\Factories;

use App\Models\Etablissement;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enseignant>
 */
class EnseignantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'PPR'=>fake()->randomNumber(6),
            'nom'=>fake()->name(),
            'prenom'=>fake()->name(),
            'date_naissance'=>fake()->dateTimeBetween('-67 years', '-27 years')->format('Y-m-d'),
            'id_etab'=>Etablissement::all()->random()->id,
            'id_grade'=>Grade::all()->random()->id,
            'id_user'=>User::all()->random()->id,
        ];
    }
}
