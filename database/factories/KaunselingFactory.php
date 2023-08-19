<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kaunseling>
 */
class KaunselingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = now()->addDays(rand(1, 30));

        $status = $this->faker->randomElement(['baru', 'diTerima', 'diTolak']);

        return [
            'no_permohonan' => 'K-'.$date->format('Ymd').'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'tarikh_permohonan' => $date,
            'jenis_fasiliti' => $this->faker->randomElement(['Asrama', 'Kolej', 'Kediaman']),
            'status' => $status,
        ];
    }
}
