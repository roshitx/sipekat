<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Enums\ComplaintStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Complaint>
 */
class ComplaintFactory extends Factory
{

    protected $model = Complaint::class;

    public function definition(): array
    {
        $statusOptions = ['Belum Diproses', 'Sedang Diproses', 'Selesai'];

        return [
            'user_id' => rand(1, 16),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement($statusOptions)
        ];
    }
}
