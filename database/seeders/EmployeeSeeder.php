<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'active' => 1,
            'name' =>  'Stephany Villasmil',
            'email' => 'empleado1@gmail.com',
            'password' => Hash::make('empleado'),
        ])->assignRole('employee')
            ->employee()
            ->create([
                'description' => 'Lashista, Trabaja en el área de cejas, pestañas y depilación coorporal.',
                'photo' => 'stefy.jpg'
            ]);

        User::create([
            'active' => 1,
            'name' =>  'Jose David',
            'email' => 'empleado2@gmail.com',
            'password' => Hash::make('empleado'),
        ])->assignRole('employee')
            ->employee()
            ->create([
                'description' => 'Maquillador profesional y creador de contenido en el área de la Belleza de la mujer sobre (Makeup).',
                'photo' => 'jose.jpg'
            ]);


        User::create([
            'active' => 1,
            'name' =>  'Empleado',
            'email' => 'empleado3@gmail.com',
            'password' => Hash::make('empleado'),
        ])->assignRole('employee')
            ->employee()
            ->create([
                'description' => 'Peinadora para toda clase de eventos tanto para niñas y adultos.'
            ]);
    }
}
