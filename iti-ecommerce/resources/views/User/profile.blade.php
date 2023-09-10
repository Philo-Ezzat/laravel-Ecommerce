<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('Assets/Css/profile.css') }}">
    <title>User Profile</title>
</head>
<body>
@include('Header and Footer.header')

<h2>Edit Profile</h2>

@if(!session('user_id'))
    redirect()->route('login');
@endif

<div class="container2">
    <form method="POST" action="{{ route('profile.update', ['id' => $user->id]) }}">
        @csrf
        @method('PUT') 

        <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" readonly style="background-color:#a9a9a9;">
            </div>
    
            <div class="form-group">
                <label for="old_password">Old Password</label>
                <input type="password" id="old_password" name="old_password" class="form-control">
                @if(session('error'))
                <div class="alert alert-danger" style="color:red; margin-top:5px;">
                 {{ session('error') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
            </div>
            
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

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
</body>
</html>
