<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/admin', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('admin.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // 
    Route::get('/admin/tracks', [TrackController::class, 'index'])->name('tracks.index');
    Route::post('/admin/tracks/store', [TrackController::class, 'store'])->name('tracks.store');
    Route::get('/admin/tracks/{track}/edit', [TrackController::class, 'edit'])->name('tracks.edit');
    Route::patch('/admin/tracks/{track}', [TrackController::class, 'update'])->name('tracks.update');
    Route::delete('/admin/tracks/{track}', [TrackController::class, 'destroy'])->name('tracks.destroy');
});


require __DIR__.'/auth.php';
