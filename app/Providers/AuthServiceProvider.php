<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use App\User;
use Auth;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        Gate::define('see-users', function ($user, $positionID) {
            return $user->positionID == $positionID;
        });
        Gate::define('admin-user', function ($user, $userUpdateID) {
            return $user->id == $userUpdateID || $user->positionID==1 || $user->positionID==2;
        });
        Gate::define('admin', function ($user) {
            return $user->positionID==1 || $user->positionID==2;
        });
    }
}
