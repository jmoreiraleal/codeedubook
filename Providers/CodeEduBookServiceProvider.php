<?php

namespace CodeEduBook\Providers;

use Illuminate\Support\ServiceProvider;

class CodeEduBookServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('codeedubook.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'codeedubook'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/codeedubook');

        $sourcePath = __DIR__.'/../resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/codeedubook';
        }, \Config::get('view.paths')), [$sourcePath]), 'codeedubook');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/codeedubook');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'codeedubook');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../resources/lang', 'codeedubook');
        }
    }

    /**
     * Resgister Migrations e seeders
     * @return void
     */
    public function publishMigartrionsSeeders()
    {
        $soucePath = _DIR_.'/../database/migration';
        $this.$this->publishes([
            $soucePath=>database_path('migration')
        ],'migrations');
        $soucePath = __DIR__.'/../database/seeders';
        $this->publishes([
            $soucePath => database_path('seeds')
        ],'seeders');

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}