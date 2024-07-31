<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class ResultController extends Controller
{
   // Example endpoint in your controller
public function getStudentCount()

{

    // $totalStudents = Student::count();
    // // $passedCount = Student::where('status', 'passed')->count();
    // // $failedCount = Student::where('status', 'failed')->count();

    // return response()->json([
    //     'totalStudents' => $totalStudents,
    //     // 'passedCount' => $passedCount,
    //     // 'failedCount' => $failedCount,
    // ]);
    $count = Student::count(); // Assuming Student is your model

    return response()->json(['count' => $count]);
}

 
}
