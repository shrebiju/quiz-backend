<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DifficultyLevelController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuizController as AdminQuizController;
use App\Http\Controllers\User\QuizController as UserQuizController;
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
    })->middleware(['auth:sanctum', \App\Http\Middleware\CheckAdmin::class]);  
    
    // Quiz history - using UserQuizController
    Route::get('/my-attempts', [UserQuizController::class, 'myAttempts']);

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

        // Quiz routes using AdminQuizController 
        // This one is for admin to show multiple question quiz
        Route::get('/quizzes', [AdminQuizController::class, 'adminIndex']);
        Route::post('/quizzes', [AdminQuizController::class, 'store']);
        //this one is for admin to show multiple question question
        Route::get('/quizzes/{id}', [AdminQuizController::class, 'show']);

        // Questions
        Route::post('/quizzes/{id}/questions', [QuestionController::class, 'store']);
        Route::get('/quizzes/{id}/questions', [QuestionController::class, 'index']);
        // Route::delete('/quizzes/{id}', [QuestionController::class, 'destroy']);
// In your admin routes group:
Route::delete('/questions/{question}', [QuestionController::class, 'destroy']);


        // Answers
        Route::put('/answers/{id}', [AnswerController::class, 'update']);
        Route::delete('/answers/{id}', [AnswerController::class, 'destroy']);
        Route::get('/questions/{question_id}/answers', [AnswerController::class, 'index']);
        Route::post('/questions/{question_id}/answers', [AnswerController::class, 'store']);

        // Quiz attempts
        Route::get('/quiz-attempts', [QuizAttemptController::class, 'index']);
    });
});

// User routes
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('quizzes')->group(function () {
        // Using UserQuizController for user-facing routes
        Route::get('/', [UserQuizController::class, 'index']);
        Route::get('/{id}/start', [UserQuizController::class, 'startQuiz']);
        Route::post('/{id}/submit', [UserQuizController::class, 'submitQuiz']);
    });
    
    
    // Using UserQuizController for myAttempts
    Route::get('/my-attempts', [UserQuizController::class, 'myAttempts']);
});