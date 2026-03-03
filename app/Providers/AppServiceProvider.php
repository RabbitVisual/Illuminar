<?php

namespace App\Providers;

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Database\Events\NoPendingMigrations;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
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
        $runSeeds = fn () => Artisan::call('db:seed', ['--force' => true]);

        Event::listen(MigrationsEnded::class, $runSeeds);
        Event::listen(NoPendingMigrations::class, $runSeeds);
    }
}
