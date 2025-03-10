<?php

use App\Http\Controllers\API\FileController;
use Illuminate\Support\Facades\Route;

// Route::middleware('api')->post('/upload-from-url', [FileController::class, 'uploadFromUrl']);


Route::post('/upload-from-url', [FileController::class, 'uploadFromUrl']);
Route::post('/upload-file', [FileController::class, 'uploadFile']);

Route::get('/', function () {
    return response()->json(['message' => 'Hello, World!']);
});
