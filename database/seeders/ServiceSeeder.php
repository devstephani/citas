<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name' => 'Trenzado',
            'description' => 'Primer servicio',
            'image' => 'cp1.jpg',
            'active' => 1,
            'price' => 20,
            'type' => 'Estandar',
            'user_id' => User::with('roles')
                ->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['employee']);
                })
                ->first()->id
        ]);
    }
}
