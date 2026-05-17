<?php

namespace CyberAdmin\Dashboard;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Laravel\Fortify\Fortify;

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
        $this->loadViewsFrom(__DIR__ . '/Stubs/views', 'cyberadmin-auth');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadTranslationsFrom(__DIR__ . '/Lang', 'tactical');

        $this->registerDefaultRateLimiters();
        $this->registerFortifyViews();
        $this->registerLivewireComponents();
        $this->registerPublishing();
        $this->registerMiddleware();
        $this->registerCommands();
    }

    protected function registerDefaultRateLimiters()
    {
        try {
            if (class_exists(\Illuminate\Support\Facades\RateLimiter::class)) {
                $rateLimiter = app(\Illuminate\Cache\RateLimiter::class);

                if (!method_exists($rateLimiter, 'for') || !$rateLimiter->limiter('login')) {
                    \Illuminate\Support\Facades\RateLimiter::for('login', function (\Illuminate\Http\Request $request) {
                        return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->email . $request->ip());
                    });
                }

                if (!method_exists($rateLimiter, 'for') || !$rateLimiter->limiter('two-factor')) {
                    \Illuminate\Support\Facades\RateLimiter::for('two-factor', function (\Illuminate\Http\Request $request) {
                        return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->session()->get('login.id'));
                    });
                }

                if (!method_exists($rateLimiter, 'for') || !$rateLimiter->limiter('registration')) {
                    \Illuminate\Support\Facades\RateLimiter::for('registration', function (\Illuminate\Http\Request $request) {
                        return \Illuminate\Cache\RateLimiting\Limit::perMinute(10)->by($request->ip());
                    });
                }

                if (!method_exists($rateLimiter, 'for') || !$rateLimiter->limiter('reset-password')) {
                    \Illuminate\Support\Facades\RateLimiter::for('reset-password', function (\Illuminate\Http\Request $request) {
                        return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->ip());
                    });
                }

                if (!method_exists($rateLimiter, 'for') || !$rateLimiter->limiter('confirm-password')) {
                    \Illuminate\Support\Facades\RateLimiter::for('confirm-password', function (\Illuminate\Http\Request $request) {
                        return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($request->ip());
                    });
                }
            }
        } catch (\Exception $e) {
        }
    }

    protected function registerFortifyViews()
    {
        if (class_exists(Fortify::class)) {
            Fortify::loginView(function () {
                if (view()->exists('auth.login')) {
                    return view('auth.login');
                }
                return view('cyberadmin-auth::auth.login');
            });

            Fortify::registerView(function () {
                if (view()->exists('auth.register')) {
                    return view('auth.register');
                }
                return view('cyberadmin-auth::auth.register');
            });

            Fortify::requestPasswordResetLinkView(function () {
                if (view()->exists('auth.forgot-password')) {
                    return view('auth.forgot-password');
                }
                return view('cyberadmin-auth::auth.forgot-password');
            });

            Fortify::resetPasswordView(function ($request) {
                if (view()->exists('auth.reset-password')) {
                    return view('auth.reset-password', ['request' => $request]);
                }
                return view('cyberadmin-auth::auth.reset-password', ['request' => $request]);
            });
        }
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

            $this->publishes([
                __DIR__ . '/Stubs/views/auth' => resource_path('views/auth'),
            ], 'cyberadmin-auth-views');
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
