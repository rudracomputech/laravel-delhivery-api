<?php

namespace Rudracomputech\Delhivery;

use Illuminate\Support\ServiceProvider;

class DelhiveryServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    $this->mergeConfigFrom(
      __DIR__ . '/../config/delhivery.php',
      'delhivery'
    );

    $this->app->singleton('delhivery', function ($app) {
      return new DelhiveryClient(
        $app['config']['delhivery']
      );
    });
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    $this->publishes([
      __DIR__ . '/../config/delhivery.php' => config_path('delhivery.php'),
    ], 'delhivery-config');

    $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
  }
}
