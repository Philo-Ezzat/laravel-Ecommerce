<?php

namespace App\Http\Controllers;
use App\Models\orderDetails;
use App\Http\Controllers\Controller;


class orderDetailsController extends Controller
{
    public function show($id){
    
        $orderDetails = orderDetails::where('order_id', $id)
        ->with('product')
        ->get();

        return view('User/orderDetails',['orderDetails'=>$orderDetails]);

    }
    
}
