<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $csvFile = fopen(base_path('database/data/locations.csv'), 'r');

            if (!$csvFile) {
                throw new Exception("Unable to open CSV file");
            }

            $data = [];
            $rowCounter = 0;

            while (($row = fgetcsv($csvFile, 1000, ',')) !== false) {
                // Skip the first row (headers)
                if ($rowCounter === 0) {
                    $rowCounter++;
                    continue;
                }

                $data[] = [
                    'region' => $row[0],
                    'township' => $row[1],
                    'quarter' => $row[2],
                    'postal_code' => $row[3],
                    // Add more columns as needed
                ];

                // Batch insert every 1000 rows
                if (count($data) == 1000) {
                    DB::table('locations')->insert($data);
                    $data = [];
                }

                $rowCounter++;
            }

            // Insert any remaining data
            if (!empty($data)) {
                DB::table('locations')->insert($data);
            }

            fclose($csvFile);
        } catch (Exception $e) {
            // Handle exceptions (e.g., log the error, display a message, etc.)
            echo "Error: " . $e->getMessage();
        }
    }
}
