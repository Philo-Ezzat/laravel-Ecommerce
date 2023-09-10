<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('Assets/Css/orderDetails.css') }}">
    <link rel="icon" href="{{ asset('Images/favicon.ico') }}" type="image/x-icon">

    <title>Details</title>
</head>
<body>
@include('Header and Footer.header')
<div class="container3">
    <h1>Order Details</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>total Price</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($orderDetails as $Details)
            <tr>
                <td>{{ $Details->product->name }}</td>
                <td>{{ $Details->quantity}}</td>
                <td>{{ $Details->product->price }}</td>
                <td>{{ $Details->product->price * $Details->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('Header and Footer.footer')

</body>
</html>