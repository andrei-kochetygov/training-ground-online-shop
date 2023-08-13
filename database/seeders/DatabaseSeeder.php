<?php

namespace Database\Seeders;

use App\Enums\Category\CategoryAttributeName;
use App\Enums\Product\ProductAttributeName;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(5)->create();

        $categoriesIds = Category::all()->pluck(CategoryAttributeName::ID);

        \App\Models\Product::factory(100)->categorized($categoriesIds)->create();
    }
}
