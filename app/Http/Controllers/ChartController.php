<?php
namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Result;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getData()
    {
        $regions = Region::all();
        $data = [];

        foreach ($regions as $region) {
            $passCount = Result::where('region_id', $region->id)
                ->where('myanmar', '>=', 40)
                ->where('english', '>=', 40)
                ->where('mathematics', '>=', 40)
                ->where('chemistry', '>=', 40)
                ->where('physics', '>=', 40)
                ->where('biological', '>=', 40)
                ->count();

            $totalCount = Result::where('region_id', $region->id)
                ->count();

            $passRate = $totalCount > 0 ? ($passCount / $totalCount) * 100 : 0;

            $data[] = [
                'label' => $region->name,
                'data' => round($passRate, 2), // Round to 2 decimal places
            ];
        }

        return response()->json([
            'datasets' => $data,
            'labels' => $regions->pluck('name')->toArray(),
        ]);
    }
}
