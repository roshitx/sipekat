<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Roshit',
            'email' => 'auliarasyidalzahrawi@gmail.com',
            'password' => Hash::make('rosyid07'),
            'gender' => 'pria',
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Roshit Masyarakat',
            'email' => 'roshit.masyarakat@gmail.com',
            'password' => Hash::make('rosyid07'),
            'gender' => 'pria',
            'role' => 'masyarakat'
        ]);

        User::create([
            'name' => 'Roshit Petugas',
            'email' => 'roshit.petugas@gmail.com',
            'password' => Hash::make('rosyid07'),
            'gender' => 'pria',
            'role' => 'petugas'
        ]);

        $this->call([
            UserSeeder::class
        ]);
        Complaint::factory(10)->create();
    }
}
