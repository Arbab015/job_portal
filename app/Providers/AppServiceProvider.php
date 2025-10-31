<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Gate::before(function ($user, $ability) {
            $notifications_array = $user->notifications->toArray();
            $message = [];
            $myarray = [];
            foreach ($notifications_array as $notification) {
                $dataitem = $notification['data'];
                $myarray['data'] = $dataitem[0];
                $myarray['created_at'] = Carbon::parse($notification['created_at'])->diffForHumans();
                $myarray['id'] = $notification['id'];
                 $myarray['read_at'] = $notification['read_at'];
                $message[] = $myarray;
                $myarray = [];
            }
            $count =  $user->unreadNotifications->count();
            View::share('notification_arrays', $message);
            View::share('unread_notifications', $count);
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}
