<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
{
    $technologies = [
        'php' , 'vue' , 'js' , 'laravel',
        'html' , 'css' , 'node' , 'vite',
    ];

    foreach ($technologies as $technology) {
        # code...
        $newTechnology= new Technology();
        $newTechnology->name = $technology;
        $newTechnology->color = $faker->unique()->safeHexColor();
        $newTechnology->save();
    };
}
}