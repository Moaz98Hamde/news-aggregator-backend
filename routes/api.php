<?php

use App\Http\Controllers\ListArticlesController;
use App\Http\Controllers\ListCategoriesController;
use App\Http\Controllers\ListSourcesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/sources', ListSourcesController::class);
Route::get('/categories', ListCategoriesController::class);
Route::get('/articles', ListArticlesController::class);
