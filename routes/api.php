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
    
    // MenuItem Controller 
    Route::scopeBindings()->apiResource('restaurants.categories.menuItems',MenuItemController::class);

    // Table Controller
    Route::scopeBindings()->apiResource('branches.tables',TableController::class);
    
    // Order Controller
    Route::scopeBindings()->apiResource('branches.orders',OrderController::class);

    // Order ItemStatus Controller
    Route::scopeBindings()->apiResource('orders.order-items',OrderItemController::class);

    // Order Item Status History Controller
    Route::scopeBindings()->apiResource('order-items.status-histories',OrderItemStatusHistoryController::class);

    // Invoice Controller
    Route::scopeBindings()->apiResource('orders.invoices',InvoiceController::class);

    // Payment Controller
    Route::scopeBindings()->apiResource('invoices.payments',PaymentController::class);

    // Refund Controller
    Route::scopeBindings()->apiResource('invoices.refunds',RefundController::class);

    // Reservation Controller
    Route::scopeBindings()->apiResource('reservations',ReservationController::class);

    // Customer Controller
    Route::apiResource('customers', CustomerController::class);
        Route::get('customers/{customer}/wallet',[CustomerController::class, 'wallet']);
        Route::get('customers/{customer}/orders',[CustomerController::class, 'orders']);
        Route::get('customers/{customer}/reservations',[CustomerController::class, 'reservations']);
        Route::get('customers/{customer}/refunds',[CustomerController::class, 'refunds']);

    // Wallet Controller
    Route::apiResource('customers.wallets', WalletController::class);
   
    // Delivery Controller
    Route::apiResource('orders.deliveries', DeliveryController::class);
    Route::apiResource('deliveries.status-histories', DeliveryStatusHistoryController::class);
    Route::apiResource('branches.delivery-zones', DeliveryZoneController::class);
        Route::get('delivery-zones/{deliveryZone}/employees',[DeliveryZoneController::class,'employees']);
        Route::post('delivery-zones/{deliveryZone}/employees/{employee}',[DeliveryZoneController::class,'attachEmployee']);
        Route::delete('delivery-zones/{deliveryZone}/employees/{employee}',[DeliveryZoneController::class,'detachEmployee']);
        Route::put('delivery-zones/{deliveryZone}/employees',[DeliveryZoneController::class,'syncEmployees']);

        Route::get('employees/{employee}/delivery-profile',[EmployeeDeliveryProfileController::class,'show']);
        Route::post('employees/{employee}/delivery-profile',[EmployeeDeliveryProfileController::class,'store']);
        Route::put('employees/{employee}/delivery-profile/{deliveryProfile}',[EmployeeDeliveryProfileController::class,'update']);
        Route::delete('employees/{employee}/delivery-profile/{deliveryProfile}',[EmployeeDeliveryProfileController::class,'destroy']);

});


