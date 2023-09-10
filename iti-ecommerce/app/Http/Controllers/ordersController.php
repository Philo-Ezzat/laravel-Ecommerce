<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Orders;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
    {
        public function store(Request $request)
        {
            $user_id = session('user_id');
        
            $cartItems = Cart::where('user_id', $user_id)->get();
        
            // Check if there are items in the cart
            if ($cartItems->isEmpty()) {
                return '<script>alert("Cart Empty."); window.location.href = "'.route('cart.show').'";</script>';            }
        
            try {
                DB::beginTransaction();
        
                $totalCost = $request->input('cost');
        
                // Check if there is enough quantity for each product in the cart
                foreach ($cartItems as $cartItem) {
                    $product = Product::find($cartItem->product_id);
        
                    if (!$product || $product->quantity < $cartItem->quantity) {
                        DB::rollback();
                        return '<script>alert("' . $product->name . ' only has ' . $product->quantity . ' in stock"); window.location.href = "'.route('cart.show').'";</script>';
                    }
                }
        
                $order = Orders::create([
                    'user_id' => $user_id,
                    'cost' => $totalCost,
                ]);
        
                foreach ($cartItems as $cartItem) {
                    $product = Product::find($cartItem->product_id);
        
                    if ($product) {
                        $product->quantity -= $cartItem->quantity;
                        $product->save();
        
                        OrderDetails::create([
                            'order_id' => $order->id,
                            'product_id' => $cartItem->product_id,
                            'quantity' => $cartItem->quantity,
                        ]);
                    }
                }
        
                Cart::where('user_id', $user_id)->delete();
        
                DB::commit();
        
                return redirect()->route('home')->with('success', 'Order submitted successfully');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('cart.show')->with('error', 'There was an error submitting the order');
            }
        }
        
    }