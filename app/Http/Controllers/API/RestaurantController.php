<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\Restaurant;
use App\Http\Resources\RestaurantResource;
use App\Support\Http\ApiResponse;

class RestaurantController extends Controller
{
    private ApiResponse $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::query()
        ->with(['branches'])
        ->paginate(10);

        return RestaurantResource::collection($restaurants);

        // return $this->response->success(
        //     data: RestaurantResource::collection($restaurants)
        // );
    }

    /**
     * Store a newly created resourclle in storage.
     */
    public function store(StoreRestaurantRequest $request)
    {
        $data = $request->validated();
        $restaurant = Restaurant::create($data);

        
        // return response()->json(new RestaurantResource($restaurant),201);

        return $this->response->created(
            data: new RestaurantResource($restaurant),
            message: 'Restaurant created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['branches','employees']);
        
        // return new RestaurantResource($restaurant);
        
        return $this->response->success(
            data: new RestaurantResource($restaurant)
        );
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $restaurant->update(
            $request->validated()
        );

        // return new RestaurantResource($restaurant);

        return $this->response->success(
            data: new RestaurantResource($restaurant),
            message: 'Restaurant updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        // return response()->json(null,204);

        return $this->response->noContent();
    }

   
}
