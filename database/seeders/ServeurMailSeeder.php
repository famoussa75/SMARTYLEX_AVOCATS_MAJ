<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ServeurMailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('serveur_mails')->insert([
            //'id' => Str::uuid(),
            'nom' => 'Titan',
            'host' => 'smtp.titan.email',
            'smtpSecure' => 'ssl',
            'smtpPort' => 465,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
