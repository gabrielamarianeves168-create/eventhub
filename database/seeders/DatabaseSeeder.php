<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'admin@eventhub.test'],
            [
                 'name' => 'Administrador', 
                'password' => Hash::make('password'), 
                'role' => 'admin', 
                'status' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'usuario@eventhub.test'],
            [
                'name' => 'Usuário Demonstração',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => true,
            ]
        );

        $this->call([
            CategorySeeder::class,
            EventSeeder::class,
        ]);
    }
}
