<?php

namespace Database\Factories;

use App\Enums\Product\ProductAttributeName;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            ProductAttributeName::NAME => $this->faker->sentence(2),
            ProductAttributeName::DESCRIPTION => $this->faker->realText(100),
            ProductAttributeName::PRICE => $this->faker->randomFloat(2, 0, 300),
        ];
    }

    public function categorized(Collection $categoriesIds)
    {
        return $this->state(function () use ($categoriesIds) {
            return [
                ProductAttributeName::CATEGORY_ID => $categoriesIds->random(1)->first(),
            ];
        });
    }
}
