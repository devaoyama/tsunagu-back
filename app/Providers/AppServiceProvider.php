<?php

namespace App\Providers;

use App\Services\Group\InvitationCodeGenerator;
use App\Services\Group\InvitationCodeGeneratorInterface;
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
        $this->app->bind(
            InvitationCodeGeneratorInterface::class,
            InvitationCodeGenerator::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
