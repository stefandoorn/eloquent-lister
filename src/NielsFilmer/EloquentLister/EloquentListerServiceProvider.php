<?php namespace NielsFilmer\EloquentLister;

use Illuminate\Support\ServiceProvider;

class EloquentListerServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Register the config and view paths
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views', 'eloquent-lister');

        $this->publishes([
            __DIR__ . '/../../views' => base_path('resources/views/vendor/eloquent-lister'),
            __DIR__ . '/../../config/config.php' => config_path('model-lister.php')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php',
            'eloquent-lister'
        );

        $this->app->bind('list-builder', function($app)
        {
            return new ListBuilder($app->make('Illuminate\Http\Request'), new Factory, $app['config']['eloquent-lister']);
        });

        $this->app->alias('list-builder', 'NielsFilmer\EloquentLister\ListBuilder');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'list-builder',
        ];
    }

}
