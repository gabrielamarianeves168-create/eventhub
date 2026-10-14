<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technology = Caregory::where(
            'name',
            'Tecnologia'
        )->firstOrFail();

        $development = Category::where(
            'name',
            'Desenvolvimento'
        )->firstOrFail();

        Event::updateOrCreate(
            ['title' => 'Workshop Laravel'],
            [
                'category_id' => $development->id,
                'description' => 'Workshop introdutório 
sobre desenvolvimento de aplicações web com laravel',
                'location' => now()->addDays(7)->setTime(18, 0),
                'end_at' => now()->addDays(7)->setTime(21, 0),
                'capacity' => 30,
                'status' => 'scheduled',
            ]
        );

        Event::updateOrCreate(
            ['title' => 'Palestra sobre Inteligência Artificial'],
            
            [
                'category_id' => $technology->id,
                'description' => 'Palestra sobre aplicações da IA
                no desenvolvimento de sistemas',
                'location' => now()->addDays(14)->setTime(19, 0),
                'end_at' => now()->addDays(14)->setTime(21, 0),
                'capacity' => 100,
                'status' => 'scheduled',
            ]
        );
    }
}
