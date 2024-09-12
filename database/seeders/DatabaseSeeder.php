<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Application;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Recrutador Teste',
            "email" => 'recrutador@teste.com',
            "senha" => Hash::make('123'),
            "cpf" => substr(str_shuffle('01234567890123456789'),1,11),
            "professional_resume" => "",
            "user_type" => "recrutador",
        ]);

        User::factory()->create([
            'name' => 'Candidato Teste',
            "email" => 'usario@teste.com',
            "senha" => Hash::make('123'),
            "cpf" => substr(str_shuffle('01234567890123456789'),1,11),
            "professional_resume" => "",
            "user_type" => "candidato",
        ]);

        User::factory()->count(98)->create();
        Vacancy::factory()->count(100)->create();
        Application::factory()->count(100)->create();
    }
}
