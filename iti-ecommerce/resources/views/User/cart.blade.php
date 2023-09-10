<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="{{ asset('Assets/Css/cart.css') }}">

</head>
<body>

@include('Header and Footer.header')



<div class="cart-container">
@if(session('error'))
    <div class="alert alert-danger" style="color: red;">
        {{ session('error') }}
    </div>
@endif
    <h1>Your Shopping Cart</h1>
    <table>
        <thead>
            <tr>
                <th  colspan="2">Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalItems = 0;
                $cartTotal = 0;
            @endphp
            @foreach ($cartItems as $cartItem)
                @php
                    $totalItems += $cartItem->quantity;
                    $cartTotal += $cartItem->quantity * $cartItem->product->price;
                @endphp
                <tr>
                    <td>{{ $cartItem->product->name }}</td>
                    <td><img src="../Images/{{ $cartItem->product->image }}" alt="Product 1" width="100px" ></td>
                    <td>${{ $cartItem->product->price }}</td>
                    <td>
                        <select name="quantity" class="quantity-select" data-cart-item-id="{{ $cartItem->id }}">
                            <option value="{{ $cartItem->quantity }}">{{ $cartItem->quantity }}</option>
                            @for ($i = 1; $i <= $cartItem->product->quantity; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </td>
                    <td>{{ $cartItem->quantity * $cartItem->product->price }}</td>
                    <td><button class="remove-button" data-cart-item-id="{{ $cartItem->id }}">Remove</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="cart-summary">
        <p>Total Items: <span id="total-items">{{ $totalItems }}</span></p>
        <p>Total Price: <span id="cart-total">${{ number_format($cartTotal, 2) }}</span></p>
    </div>
    <form action="{{ route('submitOrder') }}" method="POST">
        @csrf
        <input type="hidden" value="{{ $cartTotal }}" name="cost">
        <button class="checkout-button" type="submit">Checkout</button>
    </form>
</div>

@include('Header and Footer.footer')

<script>
    $(document).ready(function () {
        // Listen for changes in the quantity select boxes
        $('.quantity-select').on('change', function () {
            var newQuantity = $(this).val();
            var cartItemId = $(this).data('cart-item-id');

            $.ajax({
                type: 'POST',
                url: '/cart/update/' + cartItemId,
                data: {
                    quantity: newQuantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    setTimeout(function () {
                        location.reload();
                    });
                },
                error: function (xhr, status, error) {
                    // Handle errors, if any
                }
            });
        });

        // Listen for clicks on the "Remove" buttons
        $('.remove-button').on('click', function () {
            var cartItemId = $(this).data('cart-item-id');

            $.ajax({
                type: 'POST',
                url: '/cart/remove/' + cartItemId,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    setTimeout(function () {
                        location.reload();
                    });
                },
                error: function (xhr, status, error) {
                    // Handle errors, if any
                }
            });
        });
    });
</script>

</body>
</html>
