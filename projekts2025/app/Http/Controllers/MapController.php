<?php
namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function fetchLocations()
    {
        $locations = Location::all();
        return response()->json($locations);
    }

    public function dashboard()
    {
        return view('dashboard.home');
    }

    public function karte()
    {
        return view('dashboard.karte');
    }
}