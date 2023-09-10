<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('cost', 10, 2);
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('orders');
    }
    
};
