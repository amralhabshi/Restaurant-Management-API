<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\BranchResource;
use App\Http\Resources\UserResource;
use App\Models\Employee;
use App\Models\Restaurant;
use App\Http\Resources\EmployeeResource;
use App\Models\Branch;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        $employees = $restaurant->employees()
        ->with(['branches','user'])
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

        return response()->json(new EmployeeResource($employee),201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant, Employee $employee)
    {
        $employee->load(['employees','user']);
        
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Restaurant $restaurant, Employee $employee)
    {
        $employee->update(
            $request->validated()
        );

        return new EmployeeResource($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant , Employee $employee)
    {
        $employee->delete();

        return response()->json(null,204);
    }

    // عرض فروع الموظف
    public function branches(Employee $employee)
    {
        $branches = $employee->branches()->get();

        return BranchResource::collection($branches);
    }

    // اضافة فرع للموظف
    public function attachBranch(Employee $employee,Branch $branch)
    {
        $employee->branches()->attach($branch->id,
        ['is_primary'=>false,'assigned_at'=>now()]);

        return response()->json(['message'=>'Branch assigned successfully']);
    }

    // ازالة فرع من الموظف
    public function detachBranch(Employee $employee,Branch $branch)
    {
        $employee->branches()->detach($branch->id);
        
        return response()->json(['message'=>'Branch removed']);
    }

    // تحديث فروع الموظف
    public function syncBranches(Request $request,Employee $employee)
    {
        $employee->branches()->sync($request->branches);

        return response()->json(['message'=>'Branches updated']);
    }
    
    // User
    public function user(Employee $employee)
    {
        // لا نضيف () لانها علاقة نتيجة واحدة فقط hasMany
        $employee->load('user');

        return new UserResource($employee->user);
    }
    
}
