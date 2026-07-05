<?php

use App\Http\Controllers\BranchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;

Route::get('/', function () {
    return view('welcome');
});


// // نستخدم resource لجلب CRUD الموجودة
// Route::resource('restaurants',RestaurantController::class);
// // لحماية الرابط باستخدام Middleware
// Route::put('/restaurants/{restaurant}',[RestaurantController::class,'update'])
// ->can('update','restaurant');

// Route::resource('restaurants.branches',BranchController::class)->scoped();
// Route::resource('branches',BranchController::class)
// ->middleware('auth');
// Route::put('/branches/{branch}',[BranchController::class,'update'])
// ->middleware('can:update,branch');


// Route::get('/restaurants',[RestaurantController::class, 'index']);
// Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);
// Route::get('/restaurants/create', [RestaurantController::class, 'create']);
// Route::post('/restaurants', [RestaurantController::class, 'store']);
// Route::get('/edit', [RestaurantController::class, 'edit']);
