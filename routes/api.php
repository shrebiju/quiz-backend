<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DifficultyLevelController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
// use App\Http\Controllers\QuizController;
use App\Http\Controllers\User\QuizController;

use App\Http\Controllers\QuizAttemptController;
use App\Http\Middleware\CheckAdmin;


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Basic auth routes
    Route::get('/user', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Test middleware route
    Route::get('/middleware-test', function() {
        return response()->json(['status' => 'Middleware working!']);
    })->middleware('admin');

    Route::get('/admin-test', function() {
        return response()->json(['status' => 'Admin verified!']);
    })->middleware(['auth:sanctum', \App\Http\Middleware\CheckAdmin::class]); // Using FQCN  
    
    //for quiz history 
    Route::get('/my-attempts', [QuizController::class, 'myAttempts']);

   // Admin routes group
   Route::prefix('admin')->middleware([\App\Http\Middleware\CheckAdmin::class])->group(function () {
    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    
    // Difficulty Levels
    Route::get('/difficulty-levels', [DifficultyLevelController::class, 'index']);
    Route::post('/difficulty-levels', [DifficultyLevelController::class, 'store']);
    Route::put('/difficulty-levels/{difficulty_level}', [DifficultyLevelController::class, 'update']);
    Route::delete('/difficulty-levels/{difficulty_level}', [DifficultyLevelController::class, 'destroy']);

    //Quiz
    Route::get('/quizzes', [QuizController::class, 'adminIndex']);
    Route::post('/quizzes', [QuizController::class, 'store']);
    Route::get('/quizzes/{id}', [QuizController::class, 'show']);

    //For Question
    Route::post('/quizzes/{id}/questions', [QuestionController::class, 'store']);
    Route::get('/quizzes/{id}/questions', [QuestionController::class, 'index']);

    //For answer 

    // Route::get('/questions/{question_id}/answers', [AnswerController::class, 'index']);
    Route::put('/answers/{id}', [AnswerController::class, 'update']);
    Route::delete('/answers/{id}', [AnswerController::class, 'destroy']);

    //fro all anaswer
    Route::get('/questions/{question_id}/answers', [AnswerController::class, 'index']);
    Route::post('/questions/{question_id}/answers', [AnswerController::class, 'store']);

    //for Quiz attempt 
    Route::get('/quiz-attempts', [QuizAttemptController::class, 'index']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::prefix('quizzes')->group(function () {
        // web.php or api.php
        Route::get('/', [\App\Http\Controllers\QuizController::class, 'index']);
        Route::get('/{id}/start', [\App\Http\Controllers\QuizController::class, 'startQuiz']);
        Route::post('/{id}/submit', [\App\Http\Controllers\QuizController::class, 'submitQuiz']);
    });
    
    Route::get('/my-attempts', [\App\Http\Controllers\QuizController::class, 'myAttempts']);

    // Route::middleware('auth:sanctum')->group(function () {
    //     Route::get('/quizzes', [UserQuizController::class, 'index']);
    //     // (other user routes)
    // });
});