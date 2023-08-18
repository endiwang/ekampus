<?php

namespace Database\Factories;

use App\Enums\StatusKaunseling;
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
        return [
            'no_permohonan' => 'KNSL'.$this->faker->unique()->numberBetween(1000, 9999),
            'tarikh_permohonan' => $this->faker->date(),
            'jenis_fasiliti' => $this->faker->randomElement(['Asrama', 'Kolej', 'Kediaman']),
            'status' => $this->faker->randomElement(StatusKaunseling::toValues()),
        ];
    }
}
