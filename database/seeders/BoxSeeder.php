<?php

namespace Database\Seeders;

use App\Models\Box;
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
            $numberOfProducts              = [2, 3, 4]; // random number of products in every box
            $randomIndexInNumberOfProducts = array_rand($numberOfProducts, 1);
            $productIDs                    = [1, 2, 3, 4, 5, 6, 7];

            // get random number of random products
            for ($i=0; $i < $numberOfProducts[$randomIndexInNumberOfProducts]; $i++) {
                $randomIndex = array_rand($productIDs, 1); // get random indexes
                array_push($products, $productIDs[$randomIndex]);
                unset($productIDs[$randomIndex]); // to prevent duplitate products
            }

            // insert data into pivot table
            $box->products()->sync($products);
        }
    }
}
