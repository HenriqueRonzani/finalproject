<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;

use App\Models\Admin;
use App\Policies\AdminPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => AdminPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define("viewpage", function ($user) {
            info($user->userType);
            info(auth()->user()->userType);
            info($user->userType == 3);
            info(auth()->user()->userType == 3);
            
            return $user->userType == 3;
        });
    }
}
