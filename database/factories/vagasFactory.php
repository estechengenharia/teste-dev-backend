<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SebastianBergmann\CodeCoverage\Driver\Selector;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\vagas>
 */
class vagasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nomevaga' => 'Dev Back-end',
            'empresa' => 'Estech',
            'tipo' => 'CLT',
            'status' => '1',
            
        ];
    }
}
