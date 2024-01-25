<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/builder.php', 'builder');

        Model::preventLazyLoading(true);
        Model::handleLazyLoadingViolationUsing(function (Model $model, string $relation) {
            $class = get_class($model);

            info("Attempted to lazy load [{$relation}] on model [{$class}].");
        });
         Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
