<?php

namespace App\Providers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $order =  Order::whereDate('NgayTraDon', '<=', now()->addDays(2))
        ->where('NgayTraDon', '>=', now())
        ->get();
        $order_warning = collect($order);
        View::share('data_share',['order_warning' => $order_warning]);
    }
}
