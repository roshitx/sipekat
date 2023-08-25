<?php

namespace Database\Seeders;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\User;
use Database\Factories\ComplaintFactory;
use Illuminate\Database\Seeder;


class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Complaint::factory(3)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
