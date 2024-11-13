<?php

namespace Database\Seeders;

use App\Enum\Service\TypeEnum;
use App\Models\Employee;
use App\Models\Service;
use App\Models\User;
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
            'type' => TypeEnum::Trenzado,
            'employee_id' => Employee::first()->id,
            'user_id' => User::first()->id
        ]);
    }
}
