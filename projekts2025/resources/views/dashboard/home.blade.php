<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Automašīnas apkopes un izdevumu sekošanas rīks</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
</head>
<body>
    <div class="container">
        <h2>Welcome, {{ Auth::user()->username }}!</h2>

        @if(Auth::user()->username === 'admin')
            <button onclick="window.location='{{ url('/admin') }}'" class="admin-btn">Admin</button>
        @endif
        
        <div class="button-container">
        <button onclick="window.location='{{ url('/karte') }}'" class="main-btn">Karte</button>
        <button onclick="window.location='#'" class="main-btn">Degvielas patēriņš</button>
        <button onclick="window.location='#'" class="main-btn">Izdevumu pārvaldība</button>
        <button onclick="window.location='{{ url('/calendar') }}'" class="main-btn">Apkopes kalendārs</button>
        <div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn main-btn">Logout</button>
        </form>
    </div>
</body>
</html>
