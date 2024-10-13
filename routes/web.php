<?php

use Illuminate\Support\Facades\Route;use  App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\BulkController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Registration Routes
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);




// Login Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('admin_login');
Route::post('login', [LoginController::class, 'login'])->name('login');

// Logout Route
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Protected Routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('event', EventController::class);
    Route::resource('email', EmailController::class);

    //////// test mail manually////////

    Route::get('/event-offline', [EventController::class, 'offline'])->name('event-offline');
    Route::get('/send-mail-test', [HomeController::class, 'sendMail'])->name('sendmail');

    ////////////// Import Export route /////////////////////
	Route::get('/samplefiledownload', [BulkController::class, 'sampleFileDownload'])->name('samplefiledownload');
	Route::get('/export', [BulkController::class, 'export'])->name('export');
	Route::post('/import', [BulkController::class, 'importFile'])->name('import');
});


