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
            'user_id' => User::first()->id
        ]);
        Service::create([
            'name' => 'Cejas',
            'description' => 'Segundo servicio',
            'image' => 'cp1.jpg',
            'active' => 1,
            'price' => 5,
            'type' => TypeEnum::Cejas,
            'user_id' => User::first()->id
        ]);
        Service::create([
            'name' => 'Pestañas',
            'description' => 'Tercer servicio',
            'image' => 'cp1.jpg',
            'active' => 1,
            'price' => 5,
            'type' => TypeEnum::Pestañas,
            'user_id' => User::first()->id
        ]);
        Service::create([
            'name' => 'Depilación',
            'description' => 'Cuarto servicio',
            'image' => 'cp1.jpg',
            'active' => 1,
            'price' => 10,
            'type' => TypeEnum::Depilación,
            'user_id' => User::first()->id
        ]);
    }
}
