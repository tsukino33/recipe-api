<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeImportController;
use Illuminate\Support\Facades\Route;

Route::get('/recipes', [RecipeController::class, 'index']);
Route::post('/recipes', [RecipeController::class, 'store']);
Route::get('/recipes/{recipe}', [RecipeController::class, 'show']);
Route::put('/recipes/{recipe}', [RecipeController::class, 'update']);
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy']);
Route::get('/categories', [RecipeController::class, 'categories']);
Route::post('/recipes/import', [RecipeImportController::class, 'store']);
