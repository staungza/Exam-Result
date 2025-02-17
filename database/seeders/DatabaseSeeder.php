<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RegionSeeder;
use Database\Seeders\QuarterSeeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\TownshipSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RegionSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(TownshipSeeder::class);
        // $this->call(QuarterSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(ResultSeeder::class);
    }
}
