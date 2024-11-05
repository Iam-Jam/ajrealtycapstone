<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PropertyController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/search', [SearchController::class, 'search']);

/*
Route::get('/api/properties/search', [PropertyController::class, 'search']);
*/

Route::get('/properties', [PropertyController::class, 'apiIndex']);
Route::get('/properties/{property}', [PropertyController::class, 'apiShow']);

