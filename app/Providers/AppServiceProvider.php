<?php

namespace App\Providers;

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
        // Bind the SessionService to the container
        $this->app->singleton(SessionService::class, function ($app) {
            return new SessionService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('DGA_roletypecode', '04');  // Set and share type1 globally in one line
        view()->share('Ho_roletypecode', '03');  // Set and share type1 globally in one line
        view()->share('Re_roletypecode', '02');  // Set and share type1 globally in one line
        view()->share('Dist_roletypecode', '01');  // Set and share type1 globally in one line
        view()->share('Admin_roletypecode', '05');  // Set and share type1 globally in one line
        view()->share('auditeelogin', 'I');  // Set and share type1 globally in one line
        view()->share('auditorlogin', 'A');  // Set and share type1 globally in one line

    }


}
