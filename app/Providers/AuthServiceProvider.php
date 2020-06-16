<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Passport::routes();

        Passport::routes(function ($router) {
            $router->forAccessTokens();
        });

        // Register policy rules
        Gate::define('super-admin', 'App\Policies\RolePolicy@isSuperAdmin');
        Gate::define('admin', 'App\Policies\RolePolicy@isAdmin');
        Gate::define('donor', 'App\Policies\RolePolicy@isDonor');
        Gate::define('create', 'App\Policies\RolePolicy@create');
        Gate::define('update', 'App\Policies\RolePolicy@update');
        Gate::define('destroy', 'App\Policies\RolePolicy@destroy');
        Gate::define('view', 'App\Policies\RolePolicy@view');

        Gate::define('visible', function ($user, $roles) {
            $roles = str_replace(':', ',', removeSpace($roles));

            if ($roles === '*') {
                return true;
            }

            if ($user->isAdmin() || $user->isSuperAdmin()) {
                return true;
            }

            if ($roles == 'null' || empty($roles) || $roles == 'all') {
                return true;
            }

            return $user->hasRole(explode(',', $roles));
        });
    }
}
