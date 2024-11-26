<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuaranteeController;
use App\Http\Controllers\FilesController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReviewerController;


use App\Http\Controllers\UserController;

Route::get('/', [IndexController::class, 'index'])->name('index');

// Login and Registration Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Route for the Applicant Panel
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'applicantDashboard'])->name('dashboard.applicant');
    Route::get('/guarantees', [GuaranteeController::class, 'index'])->name('applicant.guarantees');
    Route::get('/guarantees/create', [GuaranteeController::class, 'create'])->name('guarantees.create');
    Route::post('/guarantees', [GuaranteeController::class, 'store'])->name('guarantees.store');
    Route::get('/guarantees/{id}/edit', [GuaranteeController::class, 'edit'])->name('guarantees.edit');
    Route::put('/guarantees/{id}', [GuaranteeController::class, 'update'])->name('guarantees.update');
    Route::delete('/guarantees/{id}', [GuaranteeController::class, 'destroy'])->name('guarantees.destroy');
});


// Routes for the Reviewer Panel
Route::middleware(['auth', 'reviewer'])->group(function () {
    Route::get('/reviewer/dashboard', [ReviewerController::class, 'reviewerDashboard'])->name('dashboard.reviewer');
    Route::get('/reviewer/guarantees/{id}', [ReviewerController::class, 'show'])->name('reviewer.guarantees');
    Route::post('/reviewer/guarantees/{id}/update', [ReviewerController::class, 'updateGuarantee'])->name('reviewer.guarantees.update');
});




// Route for the Admin Panel
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
    Route::get('/admin/guarantees', [GuaranteeController::class, 'adminIndex'])->name('admin.guarantees');
    Route::post('/admin/guarantees', [GuaranteeController::class, 'adminStore'])->name('guarantees.store');
    Route::get('/admin/guarantees/{id}/edit', [GuaranteeController::class, 'edit'])->name('guarantees.edit');
    Route::delete('/admin/guarantees/{id}', [GuaranteeController::class, 'destroy'])->name('guarantees.destroy');
    Route::get('/admin/users', [UserController::class, 'adminIndex'])->name('admin.users');
    Route::delete('/admin/users/{user}', [UserController::class, 'adminDestroy'])->name('users.destroy');
    Route::post('/admin/users/', [UserController::class, 'adminStore'])->name('users.store');
    Route::post('/admin/users/{id}/edit', [UserController::class, 'adminUpdate'])->name('users.update');
    Route::get('/admin/files', [FilesController::class, 'adminIndex'])->name('admin.files');
    Route::post('/admin/files/upload', [FilesController::class, 'upload'])->name('files.upload');
    Route::post('/admin/files/{id}/parse', [FilesController::class, 'parse'])->name('files.parse');
    Route::get('/admin/files/{id}/download', [FilesController::class, 'download'])->name('files.download');
    Route::delete('/admin/files/{id}', [FilesController::class, 'destroy'])->name('files.destroy');
});
