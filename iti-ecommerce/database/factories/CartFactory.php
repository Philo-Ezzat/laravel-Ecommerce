<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cart;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10), 
            'product_id' => $this->faker->numberBetween(1, 10), 
            'quantity' => $this->faker->numberBetween(1, 5), 
        ];
    }
}
