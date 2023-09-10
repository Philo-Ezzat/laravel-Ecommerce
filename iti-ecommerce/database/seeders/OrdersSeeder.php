<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Orders;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        Orders::factory()->count(10)->create();
    }
}
