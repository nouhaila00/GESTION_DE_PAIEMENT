<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUnivSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'rihab@gmail.com',
            'password' => Hash::make('rihab1234'),
            'type' => 'Admin_Université',
            'name' => 'rihab'
        ]);
    }
}
