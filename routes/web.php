<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SettingController;

// Auth Routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Patients Resource
    Route::resource('patients', PatientController::class);

    // Medical Records (Nested under patients conceptually, but simple CRUD works)
    // We will store/update records via these routes
    Route::resource('medical-records', MedicalRecordController::class)->except(['index', 'show', 'create']);
    // Specific route to store a record for a patient (easier for the view forms)
    Route::post('patients/{patient}/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store-for-patient');

    // Appointments Resource
    Route::resource('appointments', AppointmentController::class);

    // Settings
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

});