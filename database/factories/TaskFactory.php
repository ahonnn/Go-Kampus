<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Subject;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'subject_id' => Subject::inRandomOrder()->first()->id ?? Subject::factory(),
            
            // Menggunakan Faker untuk membuat teks random yang masuk akal
            'title' => $this->faker->sentence(mt_rand(3, 6)), // Contoh: "Tugas Makalah Sistem Cerdas"
            'description' => $this->faker->paragraph(),
            
            // Memilih status, prioritas, dan tipe secara acak
            'status' => $this->faker->randomElement(['panding', 'in_progress', 'completed']),
            'priority' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            'type' => $this->faker->randomElement(['individual', 'group']),
            
            // Membuat tanggal deadline acak antara 1 minggu yang lalu sampai 2 minggu ke depan
            'due_date' => $this->faker->dateTimeBetween('-1 week', '+2 weeks'),
        ];
    }
}
