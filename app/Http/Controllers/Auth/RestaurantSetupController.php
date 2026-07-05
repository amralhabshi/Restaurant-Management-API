<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Restaurant;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RestaurantSetupController extends Controller
{
    public function show()
    {
        return view('auth.restaurant-setup');
    }

     public function store(Request $request)
    {
       $step1 = Session::get('register_step_1');

    if (!$step1) {
        return redirect()->route('register');
    }

    $data = $request->validate([
        'restaurant_name' => 'required|string',
        'restaurant_phone' => 'nullable|string',
        'restaurant_email' => 'nullable|email',
        'description' => 'nullable|string',

        'branch_name' => 'required|string',
        'city' => 'required|string',
        'address' => 'required|string',
        'opening_time' => 'required',
        'closing_time' => 'required',
    ]);
        DB::beginTransaction();

    try {     
            $restaurant = Restaurant::create([
            'name' => $data['restaurant_name'],
            'phone' => $data['restaurant_phone'],
            'email' => $data['restaurant_email'],
            'description' => $data['description'],
        ]);

            $branch = $restaurant->branches()->create([
            'name' => $data['branch_name'],
            'city' => $data['city'],
            'address' => $data['address'],
            'opening_time' => $data['opening_time'],
            'closing_time' => $data['closing_time'],
            'is_main' => true,
        ]);

         $employee = Employee::create([
            'restaurant_id' => $restaurant->id,
            'first_name' => $step1['first_name'],
            'last_name' => $step1['last_name'],
            'phone' => $step1['phone'],
            'email' => $step1['email'],
            'salary' => 0,
            'hire_date' => now(),
            'status' => 'active',
        ]);

        $user = User::create([
            'employee_id' => $employee->id,
            'username' => $step1['username'],
            'password' => $step1['password'],
            'is_active' => true,
        ]);

        $ownerRole = Role::where('name','owner')
        ->firstOrFail();
        $user->roles()->attach($ownerRole);
        
        Auth::login($user);
        Session::forget('register_step_1');
        DB::commit();

        return redirect()->route('dashboard');

        } 
        
        catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors($e->getMessage());
        }
    }
}

