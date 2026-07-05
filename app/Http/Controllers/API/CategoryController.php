<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Restaurant;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        $categories = $restaurant->categories()->paginate(10);

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request , Restaurant $restaurant)
    {
        $category = $restaurant->categories()->create(
            $request->validated()
        );

        return response()->json(
            new CategoryResource($category),201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant , Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Restaurant $restaurant , Category $category)
    {
        $category->update(
            $request->validated()
        );

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant , Category $category)
    {
        $category->delete();

        return response()->json(null,204);
    }
}
