<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Http\Resources\TableResource;
use App\Models\Branch;
use App\Models\Table;
use App\Support\Http\ApiResponse;

class TableController extends Controller
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
        $tables = $branch->tables()
            ->paginate(10);

        return TableResource::collection($tables);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTableRequest $request, Branch $branch)
    {
        $table = $branch->tables()->create(
            $request->validated()
        );

        return $this->response->created(
            data: new TableResource($table),
            message: 'Table created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch, Table $table)
    {
        $table->load([
            'branch',
            'reservations',
            'orders',
        ]);

        return $this->response->success(
            data: new TableResource($table)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateTableRequest $request,
        Branch $branch,
        Table $table
    ) {
        $table->update(
            $request->validated()
        );

        return $this->response->success(
            data: new TableResource($table),
            message: 'Table updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch, Table $table)
    {
        $table->delete();

        return $this->response->noContent();
    }
}