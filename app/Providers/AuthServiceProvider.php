<?php

namespace App\Providers;

use App\Models\Produced;
use App\Models\Task;
use App\Policies\Admin\ProductionPolicy;
use App\Policies\Admin\TaskPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Task::class => TaskPolicy::class,
        Produced::class => ProductionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        ResetPassword::createUrlUsing(function ($user, string $token){
            // return URL::to('/reset-password').'/'.$token.'?email='.$user->email;
            $localUrl = 'http://localhost:5173';
            $productionUrl = 'https://sewingshop.vercel.app';
            $url = env('APP_ENV') == 'local' ? $localUrl  : $productionUrl;
            $fullUrl = "{$url}/reset-password/$token?email={$user->email}";
            
            return $fullUrl;
        });
    }
}
