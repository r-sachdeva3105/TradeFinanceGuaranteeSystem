<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuaranteeController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\UserController;

Route::get('/', [IndexController::class, 'index'])->name('index');

// Login and Registration Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Route for the **Applicant Dashboard**
Route::middleware('auth')->group(function () {
    // Applicant Dashboard Route (View Applicant's Guarantees)
    Route::get('/dashboard', [DashboardController::class, 'applicantDashboard'])->name('dashboard.applicant');

    // Guarantee Routes for Applicants
    Route::get('/guarantees', [GuaranteeController::class, 'index'])->name('guarantees.index'); // View Applicant's own guarantees
    Route::get('/guarantees/create', [GuaranteeController::class, 'create'])->name('guarantees.create'); // Create new guarantee
    Route::post('/guarantees', [GuaranteeController::class, 'store'])->name('guarantees.store'); // Store the guarantee
    Route::get('/guarantees/{id}/edit', [GuaranteeController::class, 'edit'])->name('guarantees.edit'); // Edit guarantee
    Route::put('/guarantees/{id}', [GuaranteeController::class, 'update'])->name('guarantees.update'); // Update guarantee
    Route::delete('/guarantees/{id}', [GuaranteeController::class, 'destroy'])->name('guarantees.destroy'); // Delete guarantee
});

// Route for the Admin Dashboard
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
    Route::get('/admin/guarantees', [GuaranteeController::class, 'adminIndex'])->name('admin.guarantees');
    Route::get('/admin/guarantees/{id}/edit', [GuaranteeController::class, 'edit'])->name('guarantees.edit');
    Route::delete('/admin/guarantees/{id}', [GuaranteeController::class, 'destroy'])->name('guarantees.destroy');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
});
