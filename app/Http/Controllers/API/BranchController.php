<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Branch;
use App\Http\Resources\BranchResource;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        $branches = $restaurant->branches()
        ->with('employees')
        ->paginate(10);

        return BranchResource::collection($branches);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request, Restaurant $restaurant)
    {
        $branch = $restaurant->branches()->create(
            $request->validated()
        );

        return response()->json(
            new BranchResource($branch),201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant, Branch $branch)
    {
        $branch->load(['employess']);
        
        return new BranchResource($branch);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, Restaurant $restaurant, Branch $branch)
    {
        $branch->update(
            $request->validated()
        );

        return new BranchResource($branch);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Branch $branch)
    {
        $branch->delete();

        return response()->json(null,204);
    }
}
