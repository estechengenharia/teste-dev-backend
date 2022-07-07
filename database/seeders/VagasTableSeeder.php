<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VagasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          \App\Models\User::factory()->create([
            'nomevaga' => 'Dev Back-end',
            'empresa' => 'Estech',
            'tipo' => 'CLT',
            'status' => rand(0,1),
         ]);
    }
}
