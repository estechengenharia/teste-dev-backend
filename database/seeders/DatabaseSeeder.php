<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Application;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'João Marcos',
            "email" => 'teste@teste.com',
            "cpf" => substr(str_shuffle('01234567890123456789'),1,11),
            "professional_resume" => "",
            "user_type" => "recrutador",
        ]);

        User::factory()->count(99)->create();
        Vacancy::factory()->count(100)->create();
        Application::factory()->count(100)->create();
    }
}
