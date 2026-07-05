<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;


class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::paginate(10);

        return view('restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        $this->authorize('create', Restaurant::class);

        return view('restaurants.create');
    }

    public function store(StoreRestaurantRequest $request)
    {
        // للصلاحيات
        $this->authorize('create', Restaurant::class);
        
        // نستحدم هذه الطريقة لانه لا يوجد سجل 
        $restaurant = Restaurant::create(
        $request->validated()
        );

       /**
        *  لتجهيز المنطق
        *
        * $data = $request->validated();
        * $restaurant = Restaurant::create($data);

        */

        return redirect()
        ->route('restaurants.index')
        ->with('success','Restaurant Created successfully');
        
        /**
         * API تستخدم مع 
         * 
         * return response()->json(['message'=>'crested successfully','data'=> $restaurant],201);
         * 
         */

    }

    public function show(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);

        return view('restaurants.show',compact('restaurant'));


        /**
         * API تستخدم مع 
         * 
         * return response()->json(['date' => $restaurant]);
         *  
         */
    }

    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        return view('restaurants.edit',compact('restaurant'));

    }

    
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        // للصلاحيات
        $this->authorize('update',$restaurant);
        // نستخدم هذه الطريقة لان السجل موجود 
        $restaurant->update(
        $request->validated()
        );

        return redirect()
        ->route('restaurants.index')
        ->with('success','Restaurant updated successfully');
    }

    public function destroy(Restaurant $restaurant)
    {
        // للصلاحيات
        $this->authorize('delete',$restaurant);

        $restaurant->delete();
        return redirect()
        ->route('restaurants.index')
        ->with('success','Restaurant deleted successfully');

        /**
         * لتجنب حذف البيانات بشكل نهائي نستخدم softdletes
         * نضيفها في :
         * - migrations
         * - Models
         */
    }

    
}
