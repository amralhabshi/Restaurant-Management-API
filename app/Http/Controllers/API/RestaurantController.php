<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\Restaurant;
use App\Http\Resources\RestaurantResource;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::query()
        ->with(['branches'])
        ->paginate(10);

        return RestaurantResource::collection($restaurants);
    }

    /**
     * Store a newly created resourclle in storage.
     */
    public function store(StoreRestaurantRequest $request)
    {
        $data = $request->validated();
        $restaurant = Restaurant::create($data);

        return response()->json(new RestaurantResource($restaurant),201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['branches','employees']);
        
        return new RestaurantResource($restaurant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $restaurant->update(
            $request->validated()
        );

        return new RestaurantResource($restaurant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return response()->json(null,204);
    }
}
