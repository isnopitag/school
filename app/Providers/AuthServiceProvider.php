<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


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

        $this->registerRootPolicies();
        $this->registerSuperadminPolicies();
        $this->registerClientPolicies();

    }

    public function registerRootPolicies(){

        Gate::define('web_root', function ($user){
            return $user->inRole('root');
        });

    }

    public function registerSuperadminPolicies(){
        Gate::define('web_admin', function ($user){
            return $user->inRole('superadmin');
        });
    }

    public function registerClientPolicies(){
        Gate::define('web_user', function ($user){
            return $user->inRole('client');
        });
    }
}
