<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TranscriptionController;

Route::middleware('web')->group(function () {
    // Auth APIs
    Route::get('login', [AuthController::class, 'showLogin']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);

    // Protected APIs
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'index']);

        Route::resource('patients', PatientController::class)->only(['index', 'show']);

        Route::resource('medical-records', MedicalRecordController::class)
            ->except(['index', 'show', 'create']);

        Route::post('patients/{patient}/medical-records', [MedicalRecordController::class, 'store']);

        Route::resource('appointments', AppointmentController::class)->only(['index']);

        Route::post('transcribe', [TranscriptionController::class, 'transcribe']);

        Route::get('settings', [SettingController::class, 'edit']);
        Route::put('settings', [SettingController::class, 'update']);
    });
});
