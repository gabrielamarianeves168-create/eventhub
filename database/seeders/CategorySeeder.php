<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            'Tecnologia',
            'Desenvolvimento',
            'Negócios',
            'Gestão',
            'Inovação'
        ] as $name) {
            Category::firstOrCreate([
                'name' => $name,
            ]);
        }
    }
}
