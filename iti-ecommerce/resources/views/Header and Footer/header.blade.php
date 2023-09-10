<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('Assets/Css/header.css') }}">

    <title>Header</title>

</head>
<body>
    <header>
        <div class="container">
            <a href="{{ route('home') }}"><img src="{{ asset('Assets/logo.png') }}" alt="" width="150px"></a>
            
            <nav>
          
<ul>
    
    @if(session('role')=='admin')
        
        <li>
            <form action="{{ route('logout') }}" method="POST" style="float:right;">
                @csrf
                <button id="submitbutton" type="submit">Logout</button>
            </form>
        </li>
        <li><a href="#" class="hello">Hello, {{ session('user_name') }}</a></li>
    @else
        @if(session('user_id'))
            <li>
                <form method="POST" action="{{ route('search') }} " id="searchForm">
                    @csrf
                    <input type="text" name="search" placeholder="Search...">
                    <button id="search" type="submit"> <i class="fa fa-search" style="margin-left: 5px;"></i></button>
                </form>
            </li>
            <li><a href="{{ route('home') }}">Home</a></li>
            @if(session('role')=='user')
                <li><a href="{{ route('profile.show', ['id' => session('user_id')]) }}">Profile</a></li>
                <li><a href="{{ route('cart.show') }}">Cart <i class="fa fa-shopping-cart" style="color: #00a8f3;"></i></a></li>
                <li>
                <form action="{{ route('logout') }}" method="POST" style="float:right;">
                @csrf
                <button id="submitbutton" type="submit">Logout</button>
                </form>
                </li>
                @endif

            <li><a href="#" class="hello">Hello, {{ session('user_name') }}</a></li>
        @else
            <li><a href="{{ route('login') }}">Login</a></li>
        @endif
    @endif
</ul>
            </nav>
        </div>
    </header>
</body>
</html>
