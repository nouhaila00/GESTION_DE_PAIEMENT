<?php

namespace Database\Seeders;

use App\Models\Etablissement;
use Database\Factories\EtablissementFactory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EtablissementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Etablissement::factory(5)->create();
    }
}
