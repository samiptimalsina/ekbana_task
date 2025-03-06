<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyCategory;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            Company::create([
                'category_id' => CompanyCategory::inRandomOrder()->first()->id,
                'title' => $faker->company,
                'image' => $faker->imageUrl(640, 480),
                'description' => $faker->paragraph,
                'status' => $faker->boolean,
            ]);
        }
    }
}
