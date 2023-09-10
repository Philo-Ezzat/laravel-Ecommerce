<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $fillable = ['user_id', 'cost'];
use HasFactory;
    public function orderDetails()
{
    return $this->hasMany(OrderDetail::class);
}

}
