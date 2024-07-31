<?php

namespace App\Http\Controllers;

use App\Models\Township;
use Illuminate\Http\Request;

class TownshipController extends Controller
{
    public function show($id)
    {
        $township = Township::findOrFail($id); // Assuming Region model exists with 'name' field
        return response()->json($township);
    }
    public function index(Request $request)
    {
        // logger($request->region_id);
       $townships= Township::query()->when($request->region_id, function($q) use($request){
        $q->where("region_id", $request->region_id);
       })->get(); // Fetch all regions from the database
        return response()->json($townships);
    }
}
