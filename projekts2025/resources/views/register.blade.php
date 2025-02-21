<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
</head>
<body>
    <div class="container" id="registerContainer">
        <h2>Register</h2>

        <form action="{{ url('/register') }}" method="POST">
            @csrf 
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter Username" value="{{ old('username') }}" required>
                
                @if ($errors->has('username'))
                    <div class="error">{{ $errors->first('username') }}</div>
                @endif
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter Email" value="{{ old('email') }}" required>
                
                @if ($errors->has('email'))
                    <div class="error">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter Password" required>
                
                @if ($errors->has('password'))
                    <div class="error">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                
                @if ($errors->has('password_confirmation'))
                    <div class="error">{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>

            <br>
            <button type="submit" class="login-btn">Register</button>
            <br><br>
            <button type="button" class="login-btn" onclick="window.location='{{ route('login') }}'">Already have an account? Login</button>
        </form>
    </div>
</body>
</html>
