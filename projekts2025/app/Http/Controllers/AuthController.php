<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('register');
    }

    // Handle the registration logic
    public function register(Request $request)
    {
        // Validate form data
        $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Create the user
        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        // Redirect or log the user in
        auth()->login($user);
        return redirect()->route('home'); // Change this to the appropriate route
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle the login logic
    public function login(Request $request)
    {
        // Validate form data
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Attempt login
        if (auth()->attempt($request->only('username', 'password'))) {
            return redirect()->route('home'); // Redirect to a dashboard or home
        }

        return back()->withErrors(['username' => 'Invalid credentials']);
    }
}
