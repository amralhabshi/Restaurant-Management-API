<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\BranchResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\UserResource;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Restaurant;
use App\Support\Http\ApiResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        $employees = $restaurant->employees()
            ->with(['branches', 'user'])
            ->paginate(10);

        return EmployeeResource::collection($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request, Restaurant $restaurant)
    {
        $employee = $restaurant->employees()->create(
            $request->validated()
        );

        return $this->response->created(
            data: new EmployeeResource($employee),
            message: 'Employee created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant, Employee $employee)
    {
        $employee->load(['branches', 'user']);

        return $this->response->success(
            data: new EmployeeResource($employee)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateEmployeeRequest $request,
        Restaurant $restaurant,
        Employee $employee
    ) {
        $employee->update(
            $request->validated()
        );

        return $this->response->success(
            data: new EmployeeResource($employee),
            message: 'Employee updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Employee $employee)
    {
        $employee->delete();

        return $this->response->noContent();
    }

    /**
     * Display employee branches.
     */
    public function branches(Employee $employee)
    {
        $branches = $employee->branches()->get();

        return BranchResource::collection($branches);
    }

    /**
     * Assign a branch to the employee.
     */
    public function attachBranch(Employee $employee, Branch $branch)
    {
        $employee->branches()->attach(
            $branch->id,
            [
                'is_primary' => false,
                'assigned_at' => now(),
            ]
        );

        return $this->response->success(
            message: 'Branch assigned successfully.'
        );
    }

    /**
     * Remove a branch from the employee.
     */
    public function detachBranch(Employee $employee, Branch $branch)
    {
        $employee->branches()->detach($branch->id);

        return $this->response->success(
            message: 'Branch removed successfully.'
        );
    }

    /**
     * Synchronize employee branches.
     */
    public function syncBranches(Request $request, Employee $employee)
    {
        $employee->branches()->sync($request->branches);

        return $this->response->success(
            message: 'Branches updated successfully.'
        );
    }

    /**
     * Display employee user.
     */
    public function user(Employee $employee)
    {
        $employee->load('user');

        return $this->response->success(
            data: new UserResource($employee->user)
        );
    }
}