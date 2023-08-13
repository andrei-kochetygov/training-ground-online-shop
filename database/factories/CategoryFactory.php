<?php

namespace Database\Factories;

use App\Enums\Category\CategoryAttributeName;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition()
    {
        return [
            CategoryAttributeName::NAME => $this->faker->word(),
        ];
    }
}
