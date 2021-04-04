<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class ProductSeeder extends Seeder
{
    /**
     * Fake names of products that will be inserted to DB
     *
     * @var array
     */
    private $names = [
        'carrot',
        'apple',
        'brocoli',
        'pear',
        'cherry',
        'plum',
        'pumpkin',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [];

        // Create a faker
        $faker    = Factory::create();

        for ($i = 1; $i < 10; $i++) {
            foreach ($this->names as $name) {
                $timestamp = $faker->dateTime();

                array_push($products, [
                    'supplier_id' => $faker->numberBetween(1, 10),
                    'name'        => $name,
                    'stock'       => $faker->numberBetween(0, 10),
                    'image'       => $name . '.jpg',
                    'price'       => $faker->randomFloat(2, 10.00, 100.00),
                    'created_at'  => $timestamp,
                    'updated_at'  => $timestamp,
                ]);
            }
        }

        DB::table('products')->insert($products);
    }
}
