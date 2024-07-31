<?php

namespace Database\Seeders;

use App\Models\Quarter;
use App\Models\Location;
use App\Models\Township;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $data = public_path('sql/quarters.sql');
        // $content = file_get_contents($data);
        // DB::statement($content);

        // dd(Quarter::count());

        Quarter::truncate();

        $datas = Location::select('township', 'quarter', 'postal_code')->get('township', 'quarter', 'postal_code')->toArray();

        // dd(count($datas));

        foreach ($datas as $data) {
            Quarter::create([
                'name' => $data['quarter'],
                'township_id' => Township::where('name', $data['township'])->value('id'),
                'postal_code' => $data['postal_code']
            ]);
        }
    }
}
