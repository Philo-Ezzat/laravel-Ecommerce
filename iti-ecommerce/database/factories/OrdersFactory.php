<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Orders;

class OrdersFactory extends Factory
{
    protected $model = Orders::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10), // Assuming you have 10 users
            'cost' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
