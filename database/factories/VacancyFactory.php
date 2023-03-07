<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacancy>
 */
class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type = array("clt", "pj","freelancer");

        return [
            "name" => $this->faker->name(),
            "description" => $this->faker->text(),
            "vacancy_type" => $type[array_rand($type)],
            "user_id" => 1,
            "opened" => 1
        ];
    }
}
