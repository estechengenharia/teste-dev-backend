<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
  
        $roleCandidato = \App\Models\Role::factory([
            'name' => 'Candidato'
        ])
            ->has(\App\Models\User::factory()->count(3))
            ->create();

        $roleRecrutador = \App\Models\Role::factory([
            'name' => 'Recrutador'
        ])
            ->has(\App\Models\User::factory()->count(3))
            ->create();

        $user = User::factory([
            'role_id' => 1
        ])
        ->has(
            Job::factory()->count(3)
            ->state(new Sequence(
                ['type' => ' CLT'],
                ['type' => 'PJ'],
                ['type' => 'Freelancer'],
            ))
        )
        ->create();
        


    }
}
