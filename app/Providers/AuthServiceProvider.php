<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        {
            $this->registerPolicies();

            /*
             * Checks if the user can access the given account.
             */
            Gate::define('access-account', function ($user, $account) {
                return $user->id === $account->user_id;
            });

            /*
             * Checks if the to-do belongs to the given account and project.
             */
            Gate::define('access-todo', function ($user, $account, $project, $todo) {
                return $todo->account_id === $account->id && $todo->project_id === $project->id;
            });

            /*
             * Checks if the project belongs to the given account.
             */
            Gate::define('access-project', function ($user, $account, $project) {
                return $project->account_id === $account->id;
            });

            /*
             * Checks if the developer belongs to the given account.
             */
            Gate::define('access-developer', function ($user, $account, $developer) {
                return $developer->account_id === $account->id;
            });

            /*
             * Checks if the developer belongs to the given user.
             */
            Gate::define('user-access-developer', function ($user, $developer) {
                return $developer->user_id === $user->id;
            });
        }
    }
}
