<?php

use App\Models\Upload;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ImageController;


//Route::post('/upload', [ImageController::class, 'upload']);
Route::get('/upload', [ImageController::class, 'showClickForm'])->name('upload');
Route::post('/upload', [ImageController::class, 'upload'])->name('upload.store');
