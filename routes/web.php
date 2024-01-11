<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CalendarController;  
use App\Http\Controllers\SchedulerController; 
use App\Http\Controllers\SendMailController; 
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

// widget test page
Route::get('/test', function () { return view('pages/test'); });

// main landing page (with or without login )
Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/home', function () {
    return view('home');
});

// about this app page
Route::get('/about', function () {
    return view('about');
})->name('about');

// just in case is needed to fix an auth issue
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// route for logging in via the UA domain
Route::post('/ualogin', [UALoginController::class, 'uaLogin'])->name('ualogin');

// authenticated pages
Route::middleware('auth')->group(function () {
    // --------------------------------
    //  Main index pages for sections
    // --------------------------------
    /* admin */
    Route::get('/admin', function () { return view('admin.index'); })->name('admin.index');

    /** 
     * Admin config pages 
     */

    // User profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // session tracks
    Route::get('/admin/tracks', [TrackController::class, 'index'])->name('tracks.index');
    Route::post('/admin/tracks/store', [TrackController::class, 'store'])->name('tracks.store');
    Route::get('/admin/tracks/{track}/edit', [TrackController::class, 'edit'])->name('tracks.edit');
    Route::patch('/admin/tracks/{track}', [TrackController::class, 'update'])->name('tracks.update');
    Route::delete('/admin/tracks/{track}/destroy', [TrackController::class, 'destroy'])->name('tracks.destroy');
    // session slots
    Route::get('/admin/slots', [SlotController::class, 'index'])->name('slots.index');
    Route::post('/admin/slots/store', [SlotController::class, 'store'])->name('slots.store');
    Route::get('/admin/slots/{slot}/edit', [SlotController::class, 'edit'])->name('slots.edit');
    Route::patch('/admin/slots/{slot}', [SlotController::class, 'update'])->name('slots.update');
    Route::delete('/admin/slots/{slot}/destroy', [SlotController::class, 'destroy'])->name('slots.destroy');
    // session venues
    Route::get('/admin/venues', [VenueController::class, 'index'])->name('venues.index');
    Route::post('/admin/venues/store', [VenueController::class, 'store'])->name('venues.store');
    Route::get('/admin/venues/{venue}/edit', [VenueController::class, 'edit'])->name('venues.edit');
    Route::patch('/admin/venues/{venue}', [VenueController::class, 'update'])->name('venues.update');
    Route::delete('/admin/venues/{venue}/destroy', [VenueController::class, 'destroy'])->name('venues.destroy');
    // session events
    Route::get('/admin/events', [EventController::class, 'index'])->name('events.index');
    Route::post('/admin/events/store', [EventController::class, 'store'])->name('events.store');
    Route::get('/admin/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::patch('/admin/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/admin/events/{event}/destroy', [EventController::class, 'destroy'])->name('events.destroy');
    // sessions
    Route::get('/admin/sessions', [SessionController::class, 'index'])->name('sessions.index');
    Route::post('/admin/sessions/store', [SessionController::class, 'store'])->name('sessions.store');
    Route::get('/admin/sessions/{session}/edit', [SessionController::class, 'edit'])->name('sessions.edit');
    Route::patch('/admin/sessions/{session}', [SessionController::class, 'update'])->name('sessions.update');
    Route::delete('/admin/sessions/{session}/destroy', [SessionController::class, 'destroy'])->name('sessions.destroy');
    // users
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/admin/users/{user}', [UserController::class, 'update'])->name('users.update');

    /**
     * Schedules
     */
    // Main calendar index
    Route::get('/calendar', CalendarController::class)->name('calendar');
    // User calendar table
    Route::get('/schedule', [SchedulerController::class, 'index'])->name('schedule');
    // add sessions
    Route::get('/schedule/{session}/add', [SchedulerController::class, 'store'])->name('schedule.add');
    // delete sessions
    Route::delete('/schedule/{schedule}/destroy', [SchedulerController::class, 'destroy'])->name('schedule.destroy');
    // create initial schedule
    Route::get('/schedule/{user}', [SchedulerController::class, 'init'])->name('schedule.init');
    // User calendar print
    Route::get('/schedule/attendee/print', [SchedulerController::class, 'print'])->name('schedule.print');
    // User calendar email
    Route::get('/schedule/attendee/email', [SchedulerController::class, 'email'])->name('schedule.email');
    // Route::get('/email', [SendMailController::class, 'index']);

    /* Reports */
    Route::get('/reports', function () { return view('reports.index'); })->name('reports');

    /* test email */
    Route::get('/mailable', function() {
        $usr = App\Models\User::find(2);
        return new App\Mail\AttendeeSchedule($usr);
    });
});


require __DIR__.'/auth.php';
