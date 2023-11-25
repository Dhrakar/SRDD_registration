<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
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
    Route::delete('/admin/tracks/{track}/destroy', [TrackController::class, 'destroy'])->name('tracks.destroy');
    // 
    Route::get('/admin/slots', [SlotController::class, 'index'])->name('slots.index');
    Route::post('/admin/slots/store', [SlotController::class, 'store'])->name('slots.store');
    Route::get('/admin/slots/{slot}/edit', [SlotController::class, 'edit'])->name('slots.edit');
    Route::patch('/admin/slots/{slot}', [SlotController::class, 'update'])->name('slots.update');
    Route::delete('/admin/slots/{slot}/destroy', [SlotController::class, 'destroy'])->name('slots.destroy');
    // 
    Route::get('/admin/venues', [VenueController::class, 'index'])->name('venues.index');
    Route::post('/admin/venues/store', [VenueController::class, 'store'])->name('venues.store');
    Route::get('/admin/venues/{venue}/edit', [VenueController::class, 'edit'])->name('venues.edit');
    Route::patch('/admin/venues/{venue}', [VenueController::class, 'update'])->name('venues.update');
    Route::delete('/admin/venues/{venue}/destroy', [VenueController::class, 'destroy'])->name('venues.destroy');
    // 
    Route::get('/admin/events', [EventController::class, 'index'])->name('events.index');
    Route::post('/admin/events/store', [EventController::class, 'store'])->name('events.store');
    Route::get('/admin/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::patch('/admin/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/admin/events/{event}/destroy', [EventController::class, 'destroy'])->name('events.destroy');
    // 
    Route::get('/admin/sessions', [SessionController::class, 'index'])->name('sessions.index');
    Route::post('/admin/sessions/store', [SessionController::class, 'store'])->name('sessions.store');
    Route::get('/admin/sessions/{session}/edit', [SessionController::class, 'edit'])->name('sessions.edit');
    Route::patch('/admin/sessions/{session}', [SessionController::class, 'update'])->name('sessions.update');
    Route::delete('/admin/sessions/{session}/destroy', [SessionController::class, 'destroy'])->name('sessions.destroy');
});


require __DIR__.'/auth.php';
