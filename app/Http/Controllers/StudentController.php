<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getStudentCounts()
    {
        // Total number of students
        $totalStudents = Student::count();

        // Number of students who passed all subjects
        $passedCount = Result::where('myanmar', '>=', 40)
                             ->where('english', '>=', 40)
                             ->where('mathematics', '>=', 40)
                             ->where('chemistry', '>=', 40)
                             ->where('physics', '>=', 40)
                             ->where('biological', '>=', 40)
                             ->count();

        // Number of students who failed in at least one subject
        $failedCount = $totalStudents - $passedCount;

        // Calculate percentages
        $passPercentage = ($totalStudents > 0) ? ($passedCount / $totalStudents) * 100 : 0;
        $failPercentage = ($totalStudents > 0) ? ($failedCount / $totalStudents) * 100 : 0;
    
        return response()->json([
            'totalStudents' => $totalStudents,
            'passedCount' => $passedCount,
            'failedCount' => $failedCount,
            'passPercentage' => number_format($passPercentage, 3),
            'failPercentage' => number_format($failPercentage, 3),
        ]);
    }
}
