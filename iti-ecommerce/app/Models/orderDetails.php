<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderDetails extends Model
{
    protected $fillable = ['order_id', 'quantity','product_id'];
    use HasFactory;
    public function order()
{
    return $this->belongsTo(Order::class);
}
public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}

}
