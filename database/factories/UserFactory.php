<?php

namespace Database\Factories;

use App\Enums\User\UserAttributeName;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            UserAttributeName::EMAIL => $this->faker->unique()->safeEmail(),
            // UserAttributeName::EMAIL_VERIFIED_AT => now(),
            UserAttributeName::PASSWORD => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    // public function unverified()
    // {
    //     return $this->state(function (array $attributes) {
    //         return [
    //             UserAttributeName::EMAIL_VERIFIED_AT => null,
    //         ];
    //     });
    // }
}
