<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\GradeSeeder;
use Database\Seeders\EnseignantSeeder;
use Database\Seeders\EtablissementSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
$this->call(EtablissementSeeder::class);
$this->call(GrdeSeeder::class);
$this->call(EnseignantSeeder::class);


    }
}
