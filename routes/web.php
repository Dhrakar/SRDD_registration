<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\Auth\UALoginController;
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

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// route for logging in via the UA domain
Route::post('/ualogin', [UALoginController::class, 'uaLogin'])->name('ualogin');


Route::middleware('auth')->group(function () {
    // --------------------------------
    //  Main index pages for sections
    // --------------------------------
    /* admin */
    Route::get('/admin', function () { return view('admin.index'); })->name('admin.index');
    /* session scheduling/viewing */
    Route::get('/schedule', function () { return view('schedule.index'); })->name('schedule.index');
    /* Reports */
    Route::get('/reports', function () { return view('reports.index'); })->name('reports.index');

    /* user profile */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // 
    Route::get('/admin/tracks', [TrackController::class, 'index'])->name('tracks.index');
    Route::post('/admin/tracks/store', [TrackController::class, 'store'])->name('tracks.store');
    Route::get('/admin/tracks/{track}/edit', [TrackController::class, 'edit'])->name('tracks.edit');
    Route::patch('/admin/tracks/{track}', [TrackController::class, 'update'])->name('tracks.update');
    Route::delete('/admin/tracks/{track}', [TrackController::class, 'destroy'])->name('tracks.destroy');
    // 
    Route::get('/admin/slots', [SlotController::class, 'index'])->name('slots.index');
    Route::post('/admin/slots/store', [SlotController::class, 'store'])->name('slots.store');
    Route::get('/admin/slots/{slot}/edit', [SlotController::class, 'edit'])->name('slots.edit');
    Route::post('/admin/slots/{slot}/edit', [SlotController::class, 'delete'])->name('slots.delete');
    Route::patch('/admin/slots/{slot}', [SlotController::class, 'update'])->name('slots.update');
    Route::delete('/admin/slots/{slot}/destroy', [SlotController::class, 'destroy'])->name('slots.destroy');
});


require __DIR__.'/auth.php';
