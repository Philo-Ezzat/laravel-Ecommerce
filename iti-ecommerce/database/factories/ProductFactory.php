<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'quantity' => $this->faker->numberBetween(1, 50),
            'image' => 'product_image.jpg', // Provide actual image file name or URL
            'description' => $this->faker->paragraph,
        ];
    }
}
