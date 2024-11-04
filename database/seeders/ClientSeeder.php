<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            User::create([
                'active' => fake()->boolean(),
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => Hash::make(fake()->password()),
                'created_at' => fake()->dateTimeBetween('2024-01-01')
            ])->assignRole('client');
        }
    }
}
