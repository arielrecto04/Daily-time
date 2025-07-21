<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\ProfileController;
use App\Http\Controllers\V1\WorkScheduleController;
use App\Http\Controllers\V1\WorkHourController;
use App\Http\Controllers\V1\AuthenticationController;
use App\Http\Controllers\V1\AttendanceController;
use App\Http\Controllers\V1\OvertimeApplicationController;
use App\Http\Controllers\V1\LeaveTypeController;
use App\Http\Controllers\V1\LeaveApplicationController;
use App\Http\Controllers\V1\DepartmentController;




Route::prefix('V1')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {

        Route::prefix('users')->group(function () {
            Route::put('toggle-status/{id}', [UserController::class, 'toggleStatus']);
            Route::put('update-department/{id}', [UserController::class, 'updateDepartment']);
        });

        Route::prefix('leave-types')->group(function () {
            Route::put('update-status/{id}', [LeaveTypeController::class, 'updateStatus']);
            Route::put('update-credited/{id}', [LeaveTypeController::class, 'updateCredited']);
        });

        Route::prefix('work-schedules')->group(function () {
            Route::post('assign/{work_schedule}', [WorkScheduleController::class, 'assignWorkScheduleToUser']);
            Route::post('remove/{work_schedule}', [WorkScheduleController::class, 'removeWorkScheduleFromUser']);
        });

        Route::get('user', [AuthenticationController::class, 'getUser']);




        Route::prefix('attendances')->group(function () {
            Route::post('check-in', [AttendanceController::class, 'checkIn']);
            Route::put('check-out/{id}', [AttendanceController::class, 'checkOut']);
            Route::get('current-attendance/{id}', [AttendanceController::class, 'currentAttendance']);
            Route::get('{id}', [AttendanceController::class, 'show']);
            Route::delete('{id}', [AttendanceController::class, 'destroy']);
            Route::get('', [AttendanceController::class, 'index']);
        });

        Route::apiResource('departments', DepartmentController::class);
        Route::apiResource('overtime-applications', OvertimeApplicationController::class);
        Route::apiResource('leave-types', LeaveTypeController::class);
        Route::apiResource('leave-applications', LeaveApplicationController::class);
        Route::apiResource('users', UserController::class);
        Route::apiResource('work-hours', WorkHourController::class);
        Route::apiResource('profiles', ProfileController::class);
        Route::apiResource('work-schedules', WorkScheduleController::class);
    });
});
