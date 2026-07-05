<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Restaurant;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        // تحديد العلاقة
        $branches = $restaurant->branches()->paginate(10);

        return view('branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Restaurant $restaurant)
    {
        return View('branches.create', compact('restaurant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request,Restaurant $restaurant)
    {
        $this->authorize('create', [Branch::class, $restaurant]);

        $branch = $restaurant->branches()->create(
            $request->validated()
        );

        return redirect()
        ->route('restaurants.branches.index',$restaurant)
        ->with('success','Branch created successfuly');
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant, Branch $branch)
    {
        $this->authorize('view', $branch);
        
        $branch = $restaurant->branches()->findOrFail($branch->id);
        return view('branches.show',compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant, Branch $branch)
    {
        $branch = $restaurant->branches()->findOrFail($branch->id);
        return view('branches.edit',compact('branch'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, Restaurant $restaurant , Branch $branch)
    {
        $branch->update($request->validated());

        return redirect()
        ->route('restaurants.branches.index',$restaurant)
        ->with('success','Branch updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant , Branch $branch)
    {
        $this->authorize('delete', $branch);

        $branch->delete();

        return redirect()
        ->route('restaurants.branches.index',$restaurant)
        ->with('success','Branch deleted successfully');
    }
}

