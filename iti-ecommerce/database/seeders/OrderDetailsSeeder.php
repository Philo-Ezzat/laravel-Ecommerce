<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderDetails;

class OrderDetailsSeeder extends Seeder
{
    public function run()
    {
        OrderDetails::factory()->count(10)->create();
    }
}
