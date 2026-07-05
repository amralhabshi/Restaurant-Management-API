<?php 

namespace App\Http\Controllers\API; 
use App\Http\Controllers\Controller; 
use App\Http\Requests\StoreMenuItemRequest; 
use App\Http\Requests\UpdateMenuItemRequest; 
use App\Http\Resources\MenuItemResource;
use App\Models\Category;
use App\Models\MenuItem; 

class MenuItemController extends Controller 
{ 
    /** * Display a listing of the resource. */ 
    public function index(Category $category) 
    {
        $menuItems = $category->menuItems()->paginate(10); 
        
        return MenuItemResource::collection($menuItems); 
    } 
    
    /** * Store a newly created resource in storage. */ 
    public function store(StoreMenuItemRequest $request, Category $category) 
    {
        $MenuItem = $category->menuItems()->create(
            $request->validated()
        );

        return response()->json(new MenuItemResource($MenuItem),201); 
    } 
    
    /** * Display the specified resource. */ 
    public function show(Category $category, MenuItem $menuItem) 
    {
        return new MenuItemResource($menuItem); 
    } 
    
    /** * Update the specified resource in storage. */ 
    public function update(UpdateMenuItemRequest $request,Category $category, MenuItem $menuItem)
    {
        $menuItem->update( $request->validated() ); 

        return new MenuItemResource($menuItem); 
    } 
    
    /** * Remove the specified resource from storage. */ 
    public function destroy(Category $category, MenuItem $menuItem) 
    {
        $menuItem->delete(); 

        return response()->json(null,204);
    } 

}
