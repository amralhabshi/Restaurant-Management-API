<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RestaurantController;
use App\Http\Controllers\API\BranchController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\DeliveryController;
use App\Http\Controllers\API\DeliveryStatusHistoryController;
use App\Http\Controllers\API\DeliveryZoneController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\EmployeeDeliveryProfileController;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\MenuItemController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\OrderItemController;
use App\Http\Controllers\API\OrderItemStatusHistoryController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RefundController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\TableController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\WalletController;


Route::prefix('v1')
->middleware('auth:sanctum')
->group(function(){


    // Restaurants Controller
    Route::apiResource('restaurants',RestaurantController::class);

    // Branch Controller
    Route::scopeBindings()->apiResource('restaurants.branches', BranchController::class);

    // Employee Controller
    Route::scopeBindings()->apiResource('restaurants.employees',EmployeeController::class);

    Route::prefix('employees/{employee}')->scopeBindings()->group(function () {

        Route::get('branches', [EmployeeController::class, 'branches']);
        Route::post('branches', [EmployeeController::class, 'attachBranch']);
        Route::put('branches', [EmployeeController::class, 'syncBranches']);
        Route::delete('branches/{branch}', [EmployeeController::class, 'detachBranch']);
        Route::get('user', [EmployeeController::class, 'user']);
    });

    // User Controller
    Route::apiResource('users',UserController::class);

    // Role Controller
    Route::apiResource('roles',RoleController::class);

    Route::prefix('roles/{role}')->scopeBindings()->group(function () {

        Route::get('permissions',[RoleController::class, 'permissions']);
        Route::post('permissions',[RoleController::class, 'attachPermission']);
        Route::put('permissions',[RoleController::class, 'syncPermissions']);
        Route::delete('permissions/{permission}',[RoleController::class, 'detachPermission']);

    });

    // Permissions Controller
    Route::apiResource('permissions',PermissionController::class);

    // Category Cintroller 
    Route::scopeBindings()->apiResource('restaurants.categories',CategoryController::class); 
    
    // MenuItem Controller 
    Route::scopeBindings()->apiResource('restaurants.categories.menu-items',MenuItemController::class);

    // Table Controller
    Route::scopeBindings()->apiResource('branches.tables',TableController::class);
    
    // Order Controller
    Route::scopeBindings()
        ->apiResource('branches.orders',OrderController::class)
        ->except('destroy');

    // Order-Item Controller
    Route::scopeBindings()->apiResource('orders.order-items',OrderItemController::class);

    // Order Item Status History Controller
    Route::scopeBindings()
        ->apiResource('order-items.status-histories',OrderItemStatusHistoryController::class)
        ->only([
            'index',
            'show',
        ]);

    // Invoice Controller
    Route::scopeBindings()
        ->apiResource('orders.invoices',InvoiceController::class)
        ->only([
            'index',
            'store',
            'show',
        ]);

    // Payment Controller
    Route::scopeBindings()
        ->apiResource('invoices.payments',PaymentController::class)
        ->only([
            'index',
            'show',
            'store',
        ]);

    // Refund Controller
    Route::scopeBindings()
        ->apiResource('invoices.refunds',RefundController::class)
        ->only([
            'index',
            'show',
            'store',
        ]);

    // Reservation Controller
    Route::apiResource('reservations',ReservationController::class)
        ->except([
            'update',
            'destroy',
        ]);;

    // Customer Controller
    Route::apiResource('customers', CustomerController::class);
        Route::get('customers/{customer}/wallet',[CustomerController::class, 'wallet']);
        Route::get('customers/{customer}/orders',[CustomerController::class, 'orders']);
        Route::get('customers/{customer}/reservations',[CustomerController::class, 'reservations']);
        Route::get('customers/{customer}/refunds',[CustomerController::class, 'refunds']);

    // Wallet Controller
    Route::apiResource('customers.wallets', WalletController::class)
        ->only([
            'show',
        ]);
   
    // Delivery Controller
    Route::scopeBindings()
        ->apiResource('orders.deliveries', DeliveryController::class)
        ->only([
            'index',
            'show',
            'store',
        ]);
    Route::scopeBindings()
        ->apiResource('deliveries.status-histories', DeliveryStatusHistoryController::class)
        ->only([
            'index',
            'show',
        ]);
    Route::scopeBindings()->apiResource('branches.delivery-zones', DeliveryZoneController::class);

    Route::scopeBindings()
        ->apiResource('employees.delivery-profile', EmployeeDeliveryProfileController::class)
        ->only([
            'show',
            'update',
        ]);


    Route::prefix('delivery-zones/{deliveryZone}')->scopeBindings()->group(function () {

            Route::get('employees',[DeliveryZoneController::class,'employees']);
            Route::post('employees',[DeliveryZoneController::class,'attachEmployee']);
            Route::put('employees',[DeliveryZoneController::class,'syncEmployees']);
            Route::delete('employees/{employee}',[DeliveryZoneController::class,'detachEmployee']);

    });

        Route::get('employees/{employee}/delivery-profile',[EmployeeDeliveryProfileController::class,'show']);
        Route::post('employees/{employee}/delivery-profile',[EmployeeDeliveryProfileController::class,'store']);
        Route::put('employees/{employee}/delivery-profile/{deliveryProfile}',[EmployeeDeliveryProfileController::class,'update']);
        Route::delete('employees/{employee}/delivery-profile/{deliveryProfile}',[EmployeeDeliveryProfileController::class,'destroy']);

});


