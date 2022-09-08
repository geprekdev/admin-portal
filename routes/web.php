<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecapController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::prefix('/recaps')->group(function () {
        Route::get('/student-attendance', [RecapController::class, 'studentAttendance'])
            ->name('recaps.student-attendance');

        Route::get('/non-student-attendance', [RecapController::class, 'nonStudentAttendance'])
            ->name('recaps.non-student-attendance');

        Route::get('/classroom-attendance', [RecapController::class, 'classroomAttendance'])
            ->name('recaps.classroom-attendance');

        Route::get('/journal', [RecapController::class, 'journal'])
            ->name('recaps.journal');
    });
});
