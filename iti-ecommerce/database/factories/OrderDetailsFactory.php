<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrderDetails;

class OrderDetailsFactory extends Factory
{
    protected $model = OrderDetails::class;

    public function definition()
    {
        return [
            'order_id' => $this->faker->numberBetween(1, 10), 
            'product_id' => $this->faker->numberBetween(1, 10), 
            'quantity' => $this->faker->numberBetween(1, 5), 
        ];
    }
}
