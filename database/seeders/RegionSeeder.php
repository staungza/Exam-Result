<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $data = public_path('sql/regions.sql');
        // $content = file_get_contents($data);
        // DB::statement($content);

        Region::truncate();

        $uniqueRegions = Location::distinct()->pluck('region');

        foreach ($uniqueRegions as $uniqueRegion) {
            Region::create([
                'name' => $uniqueRegion,
            ]);
        }
    }
}
