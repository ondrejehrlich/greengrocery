<?php

namespace Database\Seeders;

use App\Models\Box;
use App\Models\Product;
use Illuminate\Database\Seeder;

class BoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create some fake boxes
        Box::factory(10)->create();

        // Fill the boxes with products
        $this->seedBoxProductPivotTable();
    }

    /**
     * Seed box_product pivot table.
     *
     * @return void
     */
    private function seedBoxProductPivotTable()
    {
        $boxes = Box::get(['id']);
        foreach ($boxes as $box) {
            $products                      = [];
            $numberOfProducts              = [4, 5, 6, 7, 8, 9, 10, 11, 12]; // random number of products in every box.
            $randomIndexInNumberOfProducts = array_rand($numberOfProducts, 1);
            $productIDs                    = [];

            // Fill $productIDs array with IDs of every product in DB.
            foreach (Product::get('id')->toArray() as $product) {
                array_push($productIDs, $product['id']);
            }

            // Get random number of random products.
            for ($i=0; $i < $numberOfProducts[$randomIndexInNumberOfProducts]; $i++) {
                $randomIndex = array_rand($productIDs, 1); // Get random indexes.
                array_push($products, $productIDs[$randomIndex]);
            }

            // Insert data into pivot table.
            $box->products()->sync($products);
        }
    }
}
