<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;

Route::get('/', [CategoriesController::class, 'index']);
Route::post('/', [CategoriesController::class, 'create']);
Route::get('/subcategory/{id}', [CategoriesController::class, 'subcategory']);
Route::get('/supplier/{id}', [CategoriesController::class, 'supplier']);
Route::get('/product/{id}', [CategoriesController::class, 'product']);
Route::get('/view', [CategoriesController::class, 'view']);
Route::get('/delete/{id}',[CategoriesController::class,'delete']);

Route::get('/products', [ProductsController::class, 'index']);
Route::post('/products', [ProductsController::class, 'create']);
Route::get('/products/view', [ProductsController::class, 'view']);
Route::get('/products/subcategory/{id}', [ProductsController::class, 'viewsubcategory']);
Route::get('/products/supplier/{id}', [ProductsController::class, 'viewsupplier']);
Route::get('/products/product/{id}', [ProductsController::class, 'viewproduct']);
Route::get('/products/delete/{id}',[ProductsController::class,'delete']);