<?php

namespace App\Filament\Widgets;

use App\Models\Result;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected function getStats(): array
    {
        $totalStudents = Student::count();

        // Calculate pass count
        $passCount = Result::where(function ($query) {
            $query->where('myanmar', '>=', 40)
                  ->where('english', '>=', 40)
                  ->where('mathematics', '>=', 40)
                  ->where('chemistry', '>=', 40)
                  ->where('physics', '>=', 40)
                  ->where('biological', '>=', 40);
        })->count();
    
        // Calculate fail count
        $failCount = Result::where(function ($query) {
            $query->where('myanmar', '<', 40)
                  ->orWhere('english', '<', 40)
                  ->orWhere('mathematics', '<', 40)
                  ->orWhere('chemistry', '<', 40)
                  ->orWhere('physics', '<', 40)
                  ->orWhere('biological', '<', 40);
        })->count();
    
        // Calculate pass percentage
        $passPercentage = ($totalStudents > 0) ? ($passCount / $totalStudents) * 100 : 0;
    
        // Calculate fail percentage
        $failPercentage = ($totalStudents > 0) ? ($failCount / $totalStudents) * 100 : 0;
    
        return [
            Stat::make('Total Student', $totalStudents)
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->description('All students from the database')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
    
            Stat::make('Student Pass', $passCount)
                ->description('Student Pass in the student database')
                ->color('success')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
    
            Stat::make('Student Fail', $failCount)
                ->description('Student Fail in the student database')
                ->color('danger')
                ->descriptionIcon('heroicon-m-arrow-trending-down'),
    
            Stat::make('Pass Percentage', number_format($passPercentage, 2) . '%')
                ->description('Pass Percentage')
                ->color('info')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
    
            Stat::make('Fail Percentage', number_format($failPercentage, 2) . '%')
                ->description('Fail Percentage')
                ->color('warning')
                ->descriptionIcon('heroicon-m-arrow-trending-down'),
        ];
    }
}
