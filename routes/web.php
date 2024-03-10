<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CalendarController;  
use App\Http\Controllers\SchedulerController; 
use App\Http\Controllers\ReportController; 
use App\Http\Controllers\Auth\UALoginController;
use Illuminate\Support\Facades\Auth;
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

/**
 * Routes that can be used with or without login
 */

// main landing page
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


/**
 * Routes for a non-logged in user
 */
Route::middleware('guest')->group(function () {

    // route for logging in via the UA domain
    Route::post('/ualogin', [UALoginController::class, 'uaLogin'])->name('ualogin');

    // Routes for non-UA logins
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

/**
 * Routes for a logged in attendee
 */
Route::middleware(['auth', 'auth.level:attendee'])->group(function () {

    // logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // password management
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // verification of the email address
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');

    // User profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* Schedulng phpa */
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
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');

    
});

/**
 * Routes for a logged in admin user
 */
Route::middleware(['auth', 'auth.level:admin'])->group(function () {

    /* admin home page */
    Route::get('/admin', function () { return view('admin.index'); })->name('admin.index');

    /** 
     * Admin config pages 
     */
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
});

/**
 * Routes that require login as the root user
 */
Route::middleware(['auth', 'auth.level:root'])->group(function () {

    // widget test page
    Route::get('/test', function () { return view('pages/test'); });

    /* test email */
    // Route::get('/mailable', function() {
    //     $usr = App\Models\User::find(2);
    //     return new App\Mail\AttendeeSchedule($usr);
    // });
});

