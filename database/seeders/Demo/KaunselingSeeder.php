<?php

namespace Database\Seeders\Demo;

use App\Models\Kaunseling;
use App\Models\User;
use Database\Factories\KaunselingFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KaunselingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()
            ->where('is_student', true)
            ->where('is_staff', false)
            ->where('is_berhenti', false)
            ->where('is_alumni', false)
            ->limit(100)
            ->inRandomOrder()
            ->each(function ($user) {
                Kaunseling::factory()->create([
                    'user_id' => $user->id,
                ]);
            });
    }
}
