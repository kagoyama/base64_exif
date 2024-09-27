<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::controller(PhotoController::class)->group(function() {
    Route::get('/exif/{photoId}', 'getPhotoExif');
});
Route::get('/{any?}', function () {
    return view('index');
});
