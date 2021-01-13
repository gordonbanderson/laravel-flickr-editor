<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\ServiceProvider;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Suilven\FlickrEditor\Console\Commands\ImportAllSets;
use Suilven\FlickrEditor\Console\Commands\ImportFlickrSet;
use Suilven\FlickrEditor\View\Components\AppLayout;

class FlickrEditorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // see https://laravel.com/docs/8.x/packages#migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        \error_log('MIG PATH: ' . __DIR__ . '/../../database/migrations');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        //   $this->loadRoutesFrom(__DIR__ . '/../../routes/auth.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'flickr-editor');

        //  Blade::componentNamespace('Suilven\\CricketArchiver\\Views\\Components', 'cricket-archiver');

        // this is required due to the change of namespace, aka using a package, otherwise
        //    Blade::component('guest-layout', GuestLayout::class);
        Blade::component('app-layout', AppLayout::class);

        $this->publishes([
            __DIR__.'/../../public' => \public_path('vendor/suilven/FlickrEditor'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../config/flickreditor.php' => \config_path('flickreditor.php'),
        ]);

        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
             ImportFlickrSet::class,
            ImportAllSets::class,
        ]);


        Passport::routes();

        //Passport::loadKeysFrom(__DIR__.'/../storage/');


        /*
         *
    Passport::tokensExpireIn(now()->addDays(15));
    Passport::refreshTokensExpireIn(now()->addDays(30));
    Passport::personalAccessTokensExpireIn(now()->addMonths(6));
         */


        // @var \Suilven\FlickrEditor\ServiceProvider\Router $router
        //    $router = $this->app['router'];
        //     $router->pushMiddlewareToGroup('web', \Illuminate\Session\Middleware\StartSession::class);
        //      $router->pushMiddlewareToGroup('web', \Illuminate\View\Middleware\ShareErrorsFromSession::class);
    }


    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
    }
}
