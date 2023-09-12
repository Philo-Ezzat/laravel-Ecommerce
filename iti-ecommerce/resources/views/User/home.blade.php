<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('Assets/Css/home.css') }}">
    <link rel="icon" href="{{ asset('Images/favicon.ico') }}" type="image/x-icon">

    <title>Home</title>
</head>
<body>
    @include('Header and Footer.header')

    <div class="card-container">
        @php $i = 0; @endphp

        @forelse ($products as $product)
            @if ($i % 3 == 0)
                <div class="row-break"></div>
            @endif

            <div class="card">
                <img src="../Images/{{ $product->image }}" alt="img" style="width: 200px; height: 200px; border-radius: 8px;">
                <h2>{{ $product->name }}</h2>
                <p class="price">{{ $product->price }}.LE</p>

                @php $productInCart = false; @endphp

                @foreach ($cartItems as $cartItem)
                    @if ($cartItem->product_id === $product->id)
                        @php $productInCart = true; @endphp
                        <div class="added-to-cart" style="color:green; margin-top:10px;">Added to Cart</div>
                    @endif
                @endforeach

                @if (!$productInCart)
                    @if(session('user_id'))
                        <form method="POST" action="{{ route('cart.add') }}">
                    @else
                        <form method="get" action="{{ route('login') }}">
                    @endif
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_name" value="{{ $product->name }}">
                        <input type="hidden" name="product_price" value="{{ $product->price }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit">Add to Cart</button>
                    </form>
                @endif
            </div>

            @php $i++; @endphp
        @empty
            <div class="no-items-found">
                <span class="sad-emoji">&#128577;</span>
                <h2>No items found.</h2>
            </div>
        @endforelse
    </div>

    @include('Header and Footer.footer')

</body>
</html>
