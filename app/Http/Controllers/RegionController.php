<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function show($id)
    {
        $region = Region::findOrFail($id); // Assuming Region model exists with 'name' field
        return response()->json($region);
    }
    public function index()
    {
        $regions = Region::all(); // Fetch all regions from the database
        return response()->json($regions);
    }
}
