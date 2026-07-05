<?php

namespace App\Providers;

use App\Models\Branch;
use App\Policies\BranchPolicy;
use App\Models\Restaurant;
use App\Policies\RestaurantPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-dashbord', function ($user){
            return $user->is_admin;
        });
        
        Gate::policy(Branch::class,BranchPolicy::class);
    }

    protected $policies = [
        Restaurant::class => RestaurantPolicy::class,
    ];
}
