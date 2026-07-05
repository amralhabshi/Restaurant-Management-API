<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RestaurantController;
use App\Http\Controllers\API\BranchController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\MenuItemController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;


// Route::get('/restaurants',[RestaurantController::class]);

// // استخدام مسار واحد
// Route::apiResource('restaurants.branches' , BranchController::class);

// // استخدام عدة مسارارت
// Route::scopeBindings()->group(function()
//     {
//         Route::get('/restaurants/{restaurant}/branches',[BranchController::class,'index']);
//         Route::post('/restaurants/{restaurant}/branches',[BranchController::class,'store']);
//         Route::get('/restaurants/{restaurant}/branches/{branch}',[BranchController::class,'show']);
//         Route::put('/restaurants/{restaurant}/branches/{branch}',[BranchController::class,'update']);
//         Route::delete('/restaurants/{restaurant}/branches/{branch}',[BranchController::class,'destory']);

//     });


// Route::scopeBindings()->group(function()
// {
//     Route::get('/restaurants/{restaurant}/employees',[EmployeeController::class,'index']);
//     Route::post('/restaurants/{restaurant}/employees',[EmployeeController::class,'store']);
//     Route::get('/restaurants/{restaurant}/employees/{employee}',[EmployeeController::class,'show']);
//     Route::put('/restaurants/{restaurant}/employees/{employee}',[EmployeeController::class,'update']);
//     Route::delete('/restaurants/{restaurant}/employees/{employee}',[EmployeeController::class,'destory']);
// });

// // عرض فروع الموظف
// Route::get('/employees/{employee}/branches',[EmployeeController::class,'branches']);
// // اضافة فرع للموظف
// Route::post('/employees/{employee}/branches/{branch}',[EmployeeController::class,'attachBranch']);
// // ازالة فرع من الموظف
// Route::delete('/employees/{employee}/branches/{branch}',[EmployeeController::class,'detachBranch']);
// // تحديث فروع الموظف
// Route::put('/employees/{employee}/branches',[EmployeeController::class,'syncBranches']);


// // Employee >> User
// Route::get('/employees/{employee}/user',[EmployeeController::class,'user']);
// // Route::post('/employees/{employee}/user',[EmployeeController::class,'createUser']);
// // Route::put('/employees/{employee}/user',[EmployeeController::class,'updateUser']);








Route::prefix('v1')
// ->middleware('auth:sanctum')
->group(function(){


    // Restaurants Controller
    Route::apiResource('restaurants',RestaurantController::class);

    // Branch Controller
    Route::scopeBindings()->apiResource('restaurants.branches',BranchController::class);

    // Employee Controller
    Route::scopeBindings()->apiResource('restaurants.employees',EmployeeController::class);


    Route::prefix('employees')->group(function(){

        Route::get('/{employee}/branches',[EmployeeController::class,'branches']);
        Route::post('/{employee}/branches/{branch}/attach', [EmployeeController::class, 'attachBranch']);
        Route::delete('/{employee}/branches/{branch}/detach', [EmployeeController::class, 'detachBranch']);
        Route::post('/{employee}/branches/sync', [EmployeeController::class, 'syncBranches']);

        Route::get('/{employee}/user',[EmployeeController::class,'user']);

    });

    // User Controller
    Route::apiResource('users',UserController::class);



    // Role Controller
    Route::apiResource('roles',RoleController::class);

    Route::prefix('roles')->group(function(){

        Route::post('/{role}/permissions/attach', [RoleController::class, 'attachPermission']);
        Route::delete('/{role}/permissions/detach', [RoleController::class, 'detachPermission']);
        Route::post('/{role}/permissions/sync', [RoleController::class, 'syncPermissions']);

    });

    // Permissions Controller
    Route::apiResource('permissions',PermissionController::class);

    // Category Cintroller 
    Route::scopeBindings()->apiResource('restaurants.categories',CategoryController::class); 
    
    //MenuItem Controller 
    Route::scopeBindings()->apiResource('restaurants.categories.menuItems',MenuItemController::class);


});


