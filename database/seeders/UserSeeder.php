<?php

namespace Database\Seeders;

use App\Models\Directorio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'status' => 1, 
                'directorio' => [
                    'nombre' => 'Alejandro',
                    'apellido' => 'Barja',
                    'telefono' => '71866454',
                ],
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'status' => $userData['status'],
            ]);

            $user->directorio()->create([
                'nombre' => $userData['directorio']['nombre'],
                'apellido' => $userData['directorio']['apellido'],
                'telefono' => $userData['directorio']['telefono'],
            ]);
        }
    }
}
