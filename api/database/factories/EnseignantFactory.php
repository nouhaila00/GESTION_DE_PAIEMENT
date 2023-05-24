<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Grade;
use App\Models\Enseignant;
use App\Models\Etablissement;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enseignant>
 */
class EnseignantFactory extends Factory
{

    public function definition()
    {
        return [
            'PPR' =>fake()->unique()->numerify('PPR######'),
            'nom' => fake()->lastName,
            'prenom' =>fake()->firstName,
            'date_naissance' =>fake()->date(),
            'id_etab' => Etablissement::all()->random()->id,
            'id_grade' => Grade::all()->random()->id,
            'id_user' => User::all()->random()->id,
        ];
    }
}
