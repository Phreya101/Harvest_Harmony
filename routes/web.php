<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Users\CTRLFeedbacks;
use App\Admin\Models\Equipments;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Users\categoryController;
use App\Http\Controllers\Users\dashboardController;
use App\Http\Controllers\Users\threadController;
use App\Models\Users\CategoryGroup;

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



Route::prefix('users')->group(function () {
    Route::get('/feedbacks', [CTRLFeedbacks::class, 'index'])->name('users.feedbacks.index');
    // Add other routes for the controller as needed
});


// route for the landing page 
Route::get('/', function () {
    return view('welcome');
});


// redirects to specific dashboard based on the role of the user 
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// admin routes here 
Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->middleware('can:admin-access')->group(function () {

    // add routes here for admin 
    Route::resource('/users', 'UserController', ['except' => ['create', 'store', 'destroy']]);
    Route::get('/announcement', [AnnouncementController::class, 'index'])->name('Announcement');
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('Schedule');

    // scheduler
    Route::get(
        '/farmers',
        [UserController::class, 'getFarmers']
    );

    Route::post('/save-event', [ScheduleController::class, 'saveEvent'])->middleware('auth');

    Route::delete('/delete-event/{id}', [ScheduleController::class, 'deleteEvent']);
});


// users routes here 
Route::namespace('App\Http\Controllers\Users')->prefix('users')->name('users.')->middleware('can:user-access')->group(function () {

    // add routes here for users 
    Route::resource('/feedback', 'CTRLFeedbacks', ['except' => ['update', 'edit', 'destroy']]);
    Route::get('/myfeedbacks', 'CTRLFeedbacks@myfeedback')->name('myfeedback');

    // Thread
    Route::get('/viewThread', [threadController::class, 'viewThread']);

    //Forum Category
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});






require __DIR__ . '/auth.php';