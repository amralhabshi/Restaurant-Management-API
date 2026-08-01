<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Http\Resources\BranchResource;
use App\Models\Branch;
use App\Models\Restaurant;
use App\Support\Http\ApiResponse;

class BranchController extends Controller
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

        return $this->response->created(
            data: new BranchResource($branch),
            message: 'Branch created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant, Branch $branch)
    {
        $branch->load(['employees']);

        return $this->response->success(
            data: new BranchResource($branch)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, Restaurant $restaurant, Branch $branch)
    {
        $branch->update(
            $request->validated()
        );

        return $this->response->success(
            data: new BranchResource($branch),
            message: 'Branch updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Branch $branch)
    {
        $branch->delete();

        return $this->response->noContent();
    }
}