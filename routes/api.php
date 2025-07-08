<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Admin Routes
    Route::prefix('admin')->middleware('is_admin')->group(function () {
        // Add admin-only routes here like:
        // /api/admin/categories, /api/admin/quizzes, etc.
    });

    // User Routes
    Route::get('/quizzes', [QuizController::class, 'index']);
    Route::get('/quizzes/{id}/start', [QuizController::class, 'start']);
    Route::post('/quizzes/{id}/submit', [QuizController::class, 'submit']);
    Route::get('/my-attempts', [QuizAttemptController::class, 'myAttempts']);
});




