<?php

namespace Database\Factories;
use Faker\Generator as Faker;
use App\Models\Etablissement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EtablissementFactory extends Factory
{


    public function definition()
    {
        return [
            'code' => fake()->unique()->numerify('ETB###'),
            'nom' =>fake()->company,
            'telephone' =>fake()->unique()->phoneNumber,
            'faxe' => fake()->phoneNumber,
            'ville' => fake()->city,
            'nbr_enseignant' =>fake()->numberBetween(1, 100),
        ];
    }
}
