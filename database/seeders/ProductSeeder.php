<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory as Faker;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $options = [0, 10, 20, 30, 40, 50, 60];
        for ($i = 1; $i <= 100; $i++) {

            Product::create([
                'token' => $faker->uuid,
                'name' => $faker->randomElement(['Nike', 'Addidas']).' '. $faker->name,
                'price' => rand(100,1000),
                'color'=>$faker->colorName,
                'genre' => $faker->randomElement(['men', 'women', 'kids']),
                'brind' => $faker->randomElement(['Nike', 'Addidas', 'Air']),
                'discount' => $options[array_rand($options)],
                'stock' => $faker->numberBetween(0, 100),
                'mainImg' => 'https://cdn.shopify.com/s/files/1/0564/0398/4463/files/AURORA_DD1391-100_PHSRH000-2000.png?v=1697528432',
            ]);
        }
    }
}
