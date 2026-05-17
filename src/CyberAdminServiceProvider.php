<?php

namespace CyberAdmin\Dashboard;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class CyberAdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/cyberadmin.php',
            'cyberadmin'
        );
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/View', 'cyberadmin');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadTranslationsFrom(__DIR__ . '/Lang', 'tactical');

        $this->registerLivewireComponents();
        $this->registerPublishing();
        $this->registerMiddleware();
        $this->registerCommands();
    }

    protected function registerLivewireComponents()
    {
        Livewire::component('theme-switcher', \CyberAdmin\Dashboard\Http\Livewire\ThemeSwitcher::class);
        Livewire::component('language-switcher', \CyberAdmin\Dashboard\Http\Livewire\LanguageSwitcher::class);
        Livewire::component('cyberadmin.dashboard', \CyberAdmin\Dashboard\Http\Livewire\Dashboard::class);
        Livewire::component('cyberadmin.settings', \CyberAdmin\Dashboard\Http\Livewire\Settings::class);
        Livewire::component('cyberadmin.profile', \CyberAdmin\Dashboard\Http\Livewire\Profile::class);
        Livewire::component('cyberadmin.users', \CyberAdmin\Dashboard\Http\Livewire\Users::class);
        Livewire::component('cyberadmin.reports', \CyberAdmin\Dashboard\Http\Livewire\Reports::class);
    }

    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/Config/cyberadmin.php' => config_path('cyberadmin.php'),
            ], 'cyberadmin-config');

            $this->publishes([
                __DIR__ . '/../resources/css' => public_path('vendor/cyberadmin/css'),
                __DIR__ . '/../resources/js' => public_path('vendor/cyberadmin/js'),
            ], 'cyberadmin-assets');

            $this->publishes([
                __DIR__ . '/Database/Migrations/' => database_path('migrations'),
            ], 'cyberadmin-migrations');
        }
    }

    protected function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('setLocale', \CyberAdmin\Dashboard\Http\Middleware\SetLocale::class);
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \CyberAdmin\Dashboard\Console\Commands\InstallCyberAdmin::class,
                \CyberAdmin\Dashboard\Console\Commands\PublishCyberAdminAssets::class,
                \CyberAdmin\Dashboard\Console\Commands\PublishCyberAdminConfig::class,
            ]);
        }
    }
}
