<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Cart; 
use App\Models\Orders; 

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    public function index()
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }   

        $orders = Orders::orderBy('id', 'DESC')->get();
        $products = Product::all();
        return view('Admin/admin', ['products' => $products],['orders' => $orders]);
    }

    public function getProducts()
    {
        if (session('role')=='admin') {
            return redirect()->route('admin');
        }   
        $products = Product::all();
        $userId = auth()->id(); 
        $cartItems = Cart::where('user_id', $userId)
            ->with('product')
            ->get();
    
        return view('User/home', ['products' => $products, 'cartItems' => $cartItems]);
    }

    public function showForAdmin($id) {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        return response()->json(['products' => [$product]]);
    }
    
    
    public function search(Request $request)
    {
        $userId = auth()->id(); 
        $cartItems = Cart::where('user_id', $userId)
            ->with('product')
            ->get();
        $query = $request->input('search');

        $products = Product::where('name', 'like', '%' . $query . '%')->get();

        return view('User/home', ['products' => $products, 'cartItems' => $cartItems]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'productName' => 'nullable|string',
            'productPrice' => 'required|numeric',
            'productImage' => 'image|mimes:jpeg,png,jpg,gif',
            'productQuantity' => 'required|numeric',
        ]);
        if($request->filled('productName')){
        if ($request->hasFile('productImage')) {
            $image = $request->file('productImage');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Images'), $imageName);

            $product = new Product();
            $product->name = $request->input('productName');
            $product->price = $request->input('productPrice');
            $product->image =  $imageName; 
            $product->quantity = $request->input('productQuantity');
            $product->save();
            Session::put('error', '');
            return redirect()->route('admin');
        } else {
            Session::put('error', 'Please Choose an image.');
            return redirect()->route('admin');
        }}
        else{
            Session::put('error', 'Please Enter the Name.');
            return redirect()->route('admin');
        }

    }

    public function update(Request $request)
    {
        try {
            $id = $request->input('selectedItemId2');
            $product = Product::find($id);

            if (!$product) {
                Session::put('error3', 'Product not found.');
                return redirect()->route('admin');
            }
            

            if ($request->filled('productPrice')) {
                $product->price = $request->input('productPrice');
            }

            else{
                $product->price =  $product->price;
            }

            if ($request->filled('productQuantity')) {
                $product->quantity = $request->input('productQuantity');
            }


            else{
                $product->quantity = $product->quantity;
            }
    
            if ($request->hasFile('productImage')) {
                $image = $request->file('productImage');
    
                if ($image->isValid()) {
                    $imagePath = public_path('Images') . '/' . $product->image;
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
    
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('Images'), $imageName);
    
                    $product->image = $imageName;
                } else {

                    return redirect()->route('admin')->with('error', 'The uploaded file is not valid.');
                }
            }
    
            $product->save();
            return redirect()->route('admin')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {

            Log::error('Error in ProductController@update: ' . $e->getMessage());
    

            return redirect()->route('admin')->with('error', 'An error occurred during the update.');
        }
    }
    

    

    public function destroy(Request $request)
    {
        $id = $request->input('selectedItemId1');
        
        $product = Product::find($id);
        if($product){
        if ($product->productImage) {
            $imagePath = public_path('Images') . '/' . $product->image;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }


        $product->delete();
        return redirect()->route('admin')->with('success', 'Product updated successfully.');


        }

        else{
            return redirect()->route('admin')->with('error', 'no product choosed.');
        }

}

    

}
