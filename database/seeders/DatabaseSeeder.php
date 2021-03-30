<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        (new SupplierSeeder)->run();
        (new ProductSeeder)->run();
        (new BoxSeeder)->run();
    }
}
