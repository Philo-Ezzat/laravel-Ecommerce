<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('Assets/Css/register.css') }}">
    <link rel="icon" href="{{ asset('Images/favicon.ico') }}" type="image/x-icon">
    <title>Register Page</title>


</head>
<body>
    <div id="logo">
        <a href="{{ route('home') }}"><img src="{{ asset('Assets/logo.png') }}" alt="" width="300px"></a>
    </div>
<div class="register-container">
    <h1>Register</h1>
    <form action="" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="name" name="name" required>

        </div>
        <div class="form-group">
            <label for="email">Email:</label>
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
            @if(session('error2'))
                <div class="alert alert-danger" style="color:red;">
                 {{ session('error2') }}
                    </div>
                @endif
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit">Register</button>
    </form>


    <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
</div>

</body>
</html>
