<?php

namespace Database\Seeders;

use App\Models\Enseignant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnseignantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Enseignant:: factory(5)->create();
    }
}
