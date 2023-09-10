<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('Assets/Css/login.css') }}">
    <link rel="icon" href="{{ asset('Images/favicon.ico') }}" type="image/x-icon">
    <title>Login Page</title>


</head>
<body>

    <div id="logo">
        <a href="{{ route('home') }}"><img src="{{ asset('Assets/logo.png') }}" alt="" width="300px"></a>
    </div>
    <div class="login-container">
        <h1>Welcome Back!</h1>
        <form action="" method="POST">
        @csrf
            <div class="form-group">
                <label for="username">Email:</label>
                <input type="email" id="email" name="email" required>
                @if(session('error'))
                <div class="alert alert-danger" style="color:red;">
                 {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <p>Not a Member Yet ? <a href="{{ route('register') }}">Signup here</a></p>

        </form>
    </div>
</body>
</html>
