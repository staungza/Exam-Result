<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Region;
use App\Models\Township;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TownshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $data = public_path('sql/townships.sql');
        // $content = file_get_contents($data);
        // DB::statement($content);

        // dd(Township::count());
        Township::truncate();

        $datas = Location::select('region', 'township')->distinct()->get('region', 'township')->toArray();

        foreach ($datas as $data) {
            // dd($data);

            // dd(Region::where('name', $data['region'])->value('id'));
            Township::create([
                'name' => $data['township'],
                'region_id' => Region::where('name', $data['region'])->value('id'),
            ]);
        }
    }
}
