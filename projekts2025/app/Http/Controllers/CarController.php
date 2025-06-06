<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'mileage' => 'required|integer',
        ]);

        $car = Car::create($validated);
        $car->users()->attach(Auth::id(), ['confirmed' => true]);

        return response()->json(['message' => 'Car added successfully.']);
    }

    public function share(Request $request, Car $car)
    {
        $validated = $request->validate([
            'user_email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $validated['user_email'])->first();

        if (!$car->users()->where('user_id', $user->id)->exists()) {
            $car->users()->attach($user->id, ['confirmed' => false]);
        }

        return response()->json(['message' => 'Car share request sent.']);
    }

    public function confirmShare(Car $car)
    {
        $userId = Auth::id();

        $car->users()->updateExistingPivot($userId, ['confirmed' => true]);

        return response()->json(['message' => 'Car share confirmed.']);
    }

    public function showPage()
    {
        $cars = auth()->user()->cars;
        return view('dashboard.izdevumi', compact('cars'));
    }

    
    public function index()
    {
        $cars = auth()->user()->cars()->with('users')->get();

        return view('dashboard.izdevumi', compact('cars'));
    }
}