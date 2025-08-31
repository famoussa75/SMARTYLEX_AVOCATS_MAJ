<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            //'id' => Str::uuid(),
            'name' => 'Consultant Dev',
            'email' => 'daboabou845@gmail.com',
            'statut' => 'actif',
            'role' => 'Administrateur',
            'initial' => 'AP',
            'photo' => null,
            'theme' => 'light',
            'lastConnexion' => rand(1, 100),
            'password' => Hash::make('root'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}