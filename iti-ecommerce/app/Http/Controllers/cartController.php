<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart; 
class CartController extends Controller
{

    public function addItem(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $userId = auth()->id(); 
    

        $existingCartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    
        if ($existingCartItem) {

            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {

            $cartItem = new Cart([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
            $cartItem->save();
        }
    
        return redirect()->route('home')->with('success', 'Item added to cart');
    }
    
public function index()
{
    if (!session('user_id')) {
        return redirect()->route('login');
    }
    $userId = auth()->id(); 

    $cartItems = Cart::where('user_id', $userId)
        ->with('product')
        ->get();

    return view('User/cart', ['cartItems' => $cartItems]);
}
public function updateItemQuantity(Request $request, $cartItemId)
{
    $newQuantity = $request->input('quantity');


    $cartItem = Cart::find($cartItemId);


    $cartItem->quantity = $newQuantity;
    $cartItem->save();

    return response()->json(['message' => 'Cart item quantity updated successfully']);
}
public function removeItem($cartItemId)
{

    $cartItem = Cart::find($cartItemId);

    $cartItem->delete();

    return response()->json(['message' => 'Cart item removed successfully']);
}


}
