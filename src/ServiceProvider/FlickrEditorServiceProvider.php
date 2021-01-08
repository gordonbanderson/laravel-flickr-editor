<?php


namespace Suilven\FlickrEditor\ServiceProvider;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Suilven\FlickrEditor\Console\Commands\ImportFlickrSet;
use Suilven\FlickrEditor\View\Components\AppLayout;

class FlickrEditorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // see https://laravel.com/docs/8.x/packages#migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        error_log('MIG PATH: ' . __DIR__ . '/../../database/migrations');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        //   $this->loadRoutesFrom(__DIR__ . '/../../routes/auth.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'flickr-editor');

        //  Blade::componentNamespace('Suilven\\CricketArchiver\\Views\\Components', 'cricket-archiver');

        // this is required due to the change of namespace, aka using a package, otherwise
        //    Blade::component('guest-layout', GuestLayout::class);
        Blade::component('app-layout', AppLayout::class);

        $this->publishes([
            __DIR__.'/../../public' => public_path('vendor/suilven/FlickrEditor'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../config/flickreditor.php' => config_path('flickreditor.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                 ImportFlickrSet::class,
            ]);


            /** @var Router $router */
            //    $router = $this->app['router'];
            //     $router->pushMiddlewareToGroup('web', \Illuminate\Session\Middleware\StartSession::class);
            //      $router->pushMiddlewareToGroup('web', \Illuminate\View\Middleware\ShareErrorsFromSession::class);
        }
    }

    public function register()
    {
        $this->app->register(EventServiceProvider::class);

    }

}