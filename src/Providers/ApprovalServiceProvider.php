<?php

namespace Prodevel\Laravel\Workflow\Providers;

use Illuminate\Support\ServiceProvider;

class ApprovalServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/approvals.php', 'approvals'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/approvals.php' => config_path('approvals.php'),
        ]);
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }
}
