<?php

use App\Models\Result;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TownshipController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Route::get('/api/student-counts', [ResultController::class, 'getStudentCounts']);
Route::get('/student-count', [ResultController::class, 'getStudentCount']);
Route::get('/student-counts', [StudentController::class, 'getStudentCounts']);
Route::get('/regions/{id}', [RegionController::class, 'show']);
Route::get('/townships/{id}', [TownshipController::class, 'show']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/students', function () {
    return Student::all();
});

// Route::get('/resultsdetail', function (Request $request) {
//     return Result::where('roll_no', $request->query('search'))->get();
// });
Route::get('/resultsdetail', function (Request $request) {
    $payload = $request->search;
    $search = Str::upper($payload);

    // $search = $request->query('search');
    // Ensure that special characters are handled properly
    return Result::where('roll_no', 'LIKE',"{$search}")->get();
});

Route::get('/results', function () {
    return Result::all();
});


Route::get('/regions', [RegionController::class, 'index']);
Route::get('/townships', [TownshipController::class, 'index']);


Route::get('/chart', [ChartController::class, 'getData']);




