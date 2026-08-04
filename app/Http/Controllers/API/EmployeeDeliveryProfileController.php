<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeDeliveryProfileRequest;
use App\Http\Requests\UpdateEmployeeDeliveryProfileRequest;
use App\Http\Resources\EmployeeDeliveryProfileResource;
use App\Models\Employee;
use App\Models\EmployeeDeliveryProfile;
use App\Support\Http\ApiResponse;

class EmployeeDeliveryProfileController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display the employee delivery profile.
     */
    public function show(Employee $employee)
    {
        $employee->load('deliveryProfile');

        return $this->response->success(
            data: new EmployeeDeliveryProfileResource(
                $employee->deliveryProfile
            )
        );
    }


    /**
     * Update profile.
     */
    public function update(UpdateEmployeeDeliveryProfileRequest $request,Employee $employee,EmployeeDeliveryProfile $deliveryProfile) 
    {
        $deliveryProfile->update(
            $request->validated()
        );

        return $this->response->success(
            data: new EmployeeDeliveryProfileResource($deliveryProfile),
            message: 'Delivery profile updated successfully.'
        );
    }

}