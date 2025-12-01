<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PTKController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\StafTU\DashboardController as StafTUDashboardController;
use App\Http\Controllers\StafTU\DocumentController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\KepalaSekolah\DashboardController as KepalaSekolahDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // PTK Management
    Route::resource('ptk', PTKController::class);
    
    // Category Management
    Route::resource('categories', CategoryController::class);
});

/*
|--------------------------------------------------------------------------
| Staf TU Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staf_tu'])->prefix('staf-tu')->name('staf-tu.')->group(function () {
    Route::get('/dashboard', [StafTUDashboardController::class, 'index'])->name('dashboard');
    
    // Document Management
    Route::resource('documents', DocumentController::class);
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('/report', [DocumentController::class, 'report'])->name('report');
});

/*
|--------------------------------------------------------------------------
| Guru Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Kepala Sekolah Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepala-sekolah')->name('kepala-sekolah.')->group(function () {
    Route::get('/dashboard', [KepalaSekolahDashboardController::class, 'index'])->name('dashboard');
    Route::get('/ptk/{ptk}', [KepalaSekolahDashboardController::class, 'showPTK'])->name('ptk.show');
});

/*
|--------------------------------------------------------------------------
| Public Document Viewer (for Guru and Kepala Sekolah)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('documents')->name('documents.')->group(function () {
    Route::get('/{document}', [DocumentController::class, 'view'])->name('view');
});
