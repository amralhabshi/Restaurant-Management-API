<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeliveryZoneRequest;
use App\Http\Requests\UpdateDeliveryZoneRequest;
use App\Http\Requests\AttachDeliveryZoneEmployeeRequest;
use App\Http\Requests\SyncDeliveryZoneEmployeesRequest;
use App\Http\Resources\DeliveryZoneResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Branch;
use App\Models\DeliveryZone;
use App\Models\Employee;
use App\Support\Http\ApiResponse;
use Illuminate\Http\Request;

class DeliveryZoneController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Branch $branch)
    {
        $zones = $branch->deliveryZones()
            ->with('employees')
            ->paginate(10);

        return DeliveryZoneResource::collection($zones);
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreDeliveryZoneRequest $request,Branch $branch) 
    {
        $zone = $branch->deliveryZones()->create(
            $request->validated()
        );

        return $this->response->created(
            data: new DeliveryZoneResource($zone),
            message: 'Delivery zone created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch,DeliveryZone $deliveryZone) 
    {
        $deliveryZone->load([
            'branch',
            'employees',
            'deliveries',
        ]);

        return $this->response->success(
            data: new DeliveryZoneResource($deliveryZone)
        );
    }

    /**
     * Update the specified resource.
     */
    public function update(UpdateDeliveryZoneRequest $request,Branch $branch,DeliveryZone $deliveryZone) 
    {
        $deliveryZone->update(
            $request->validated()
        );

        return $this->response->success(
            data: new DeliveryZoneResource($deliveryZone),
            message: 'Delivery zone updated successfully.'
        );
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Branch $branch,DeliveryZone $deliveryZone) 
    {
        $deliveryZone->delete();

        return $this->response->noContent();
    }

    /**
     * Display employees in zone.
     */
    public function employees(DeliveryZone $deliveryZone)
    {
        return EmployeeResource::collection(
            $deliveryZone->employees
        );
    }

    /**
     * Attach employee to zone.
     */
    public function attachEmployee(AttachDeliveryZoneEmployeeRequest $request, DeliveryZone $deliveryZone) 
    {
        $deliveryZone->employees()->attach(
            $request->validated()['employee_id']
        );

        return $this->response->success(
            data: null,
            message: 'Employee assigned successfully.'
        );
    }

    /**
     * Detach employee from zone.
     */
    public function detachEmployee(DeliveryZone $deliveryZone,Employee $employee) 
    {
        $deliveryZone->employees()->detach($employee->id);

        return $this->response->success(
            data: null,
            message: 'Employee detached successfully.'
        );
    }

    /**
     * Sync employees.
     */
    public function syncEmployees(SyncDeliveryZoneEmployeesRequest $request, DeliveryZone $deliveryZone) 
    {
        $deliveryZone->employees()->sync(
            $request->validated()['employees']
        );

        return $this->response->success(
            data: null,
            message: 'Employees updated successfully.'
        );
    }
}