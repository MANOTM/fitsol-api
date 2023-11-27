<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use App\Models\UltraProduct;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UltraProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 100; $i++) {
            UltraProduct::create([
                'secondImg' => 'https://cdn.shopify.com/s/files/1/0564/0398/4463/files/AURORA_DD1391-100_PHCFH001-2000.png?v=1697528439',
                'description' => $faker->paragraph . ' ' . $faker->paragraph,
                'size38' => $faker->numberBetween(0, 10),
                'size39' => $faker->numberBetween(0, 10),
                'size40' => $faker->numberBetween(0, 10),
                'size41' => $faker->numberBetween(0, 10),
                'size42' => $faker->numberBetween(0, 10),
                'size43' => $faker->numberBetween(0, 10),
                'product_id' => $i
            ]);
        }
    }
}
