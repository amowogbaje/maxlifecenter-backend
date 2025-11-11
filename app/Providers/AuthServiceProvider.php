<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as BaseAuthServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends BaseAuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // This method comes from the BaseAuthServiceProvider
        $this->registerPolicies();
        Auth::shouldUse('admin'); 

        // Avoid DB errors during migrations / first deploy
        if (! Schema::hasTable('permissions')) {
            return;
        }

        // Cache permission names for performance
        $permissionNames = Permission::pluck('name')->toArray();

        foreach ($permissionNames as $permission) {

            Gate::define($permission, function ($user) use ($permission) {
                return method_exists($user, 'hasPermission') && $user->hasPermission($permission);
            });
        }

       
    }
}
