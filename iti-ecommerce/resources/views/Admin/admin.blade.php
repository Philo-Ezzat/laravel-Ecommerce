<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('Assets/Css/admin.css') }}">
    <link rel="icon" href="{{ asset('Images/favicon.ico') }}" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <title>DashBoard</title>
</head>
<body>
@include('Header and Footer.header')




<form action="{{ route('product.delete') }}" id="deleteProduct" method="POST">
@csrf
@method('DELETE')
    <label for="selectOption">Select Product To Delete:</label>
    <select id="selectOption1" name="selectedOption" class="select2">
        @foreach($products as $product)
        <option value="{{$product->id}}">{{$product->name}}</option>
        @endforeach
    </select>
    <input type="hidden" name="selectedItemId1" id="selectedItemId1" value="">

    <button type="submit" id="deleteButton">Delete</button>
</form>









<form action="{{ route('product.add') }}" id="addProduct" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="productName">Product Name:</label>
    <input type="text" id="productName" name="productName" placeholder="Enter Product Name">
    @if(session('error'))
                <div class="alert alert-danger" style="color:red; margin-top: -8px; margin-bottom: 3px;">
                 {{ session('error') }}
                    </div>
                @endif
    <label for="productPrice">Product Price:</label>
    <input type="number" id="productPrice" name="productPrice" placeholder="Enter Product Price" value="1">

    <span >Product Image:</span>

    <input type="file" id="productImage" name="productImage">

    <label for="productQuantity">Product Quantity:</label>
    <input type="number" id="productQuantity" name="productQuantity" placeholder="Enter Product Quantity" value="1">

    <button type="submit" id="addButton">Add Product</button>
</form>















<form id="editProduct" action="{{ route('product.update') }}"  method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="selectOption">Select Product To Edit:</label>
    <select id="selectOption2" name="selectedOption" >
        @foreach($products as $product)
            <option value="{{$product->id}}">{{$product->name}}</option>
        @endforeach
    </select>
    @if(session('error3'))
                <div class="alert alert-danger" style="color:red; margin-top: -8px; margin-bottom: 3px;">
                 {{ session('error3') }}
                    </div>
                @endif
    <label for="productPrice">Product Price:</label>
    <input type="number" id="productPrice2" name="productPrice" placeholder="Enter Product Price">

    <span >Product Image:</span>
    <input type="file" id="productImage" name="productImage">

    <label for="productQuantity">Product Quantity:</label>
    <input type="number" id="productQuantity2" name="productQuantity" placeholder="Enter Product Quantity">

    <input type="hidden" name="selectedItemId2" id="selectedItemId2" value="">

    <button type="submit" id="editButton">Edit Product</button>
</form>










<div class="container3">
    <h1>Orders</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Cost</th>
                <th>Order Date</th>
                <th>Order Details</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->cost }}</td>
                <td>{{ $order->created_at }}</td>
                <td><form method="GET" action="{{ route('details.show', ['id' => $order->id]) }}"><button class="details-Button" type="submit">See Details</button></form></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@include('Header and Footer.footer')





<script>

    document.addEventListener("DOMContentLoaded", function() {
        var selectOption = document.getElementById("selectOption2");
        var selectedItemIdField = document.getElementById("selectedItemId2");
        var productPrice = document.getElementById("productPrice2");
        var productQuantity = document.getElementById("productQuantity2");

        // Initial fetch when the page loads
        var selectedItemId = selectOption.value;
        selectedItemIdField.value = selectedItemId;
        fetchProductDetails(selectedItemId);

        selectOption.addEventListener("change", function() {
            var selectedItemId = selectOption.value;
            selectedItemIdField.value = selectedItemId;

            // Fetch product details when a new item is selected
            fetchProductDetails(selectedItemId);
        });

        function fetchProductDetails(productId) {
            $.ajax({
        type: 'GET',
        url: '/DashBoard/' + productId, 
        success: function(response) {
            if (response.products) {
                var product = response.products[0];
                
                var quantity = product.quantity;
                var price = product.price;
                console.log(quantity);
                console.log(price);
                console.log(product);
                productPrice.value = price;
                productQuantity.value = quantity;
            } else {
                
                console.error("No 'products' array in the response.");
            }
        },
        error: function(xhr, status, error) {
            // Handle errors, if any
        }
    });
        }
    });








document.addEventListener("DOMContentLoaded", function() {

var selectOption = document.getElementById("selectOption1");
var selectedItemIdField = document.getElementById("selectedItemId1");
var selectedItemId = selectOption.value;
selectedItemIdField.value = selectedItemId;
selectOption.addEventListener("change", function () {

    var selectedItemId = selectOption.value;
    selectedItemIdField.value = selectedItemId;
});
});

</script>

</body>
</html>
