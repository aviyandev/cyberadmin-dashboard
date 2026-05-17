<?php

namespace CyberAdmin\Dashboard\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallCyberAdmin extends Command
{
    protected $signature = 'cyberadmin:install';
    protected $description = 'Install CyberAdmin Dashboard with all dependencies and setup';

    protected $steps = [];

    public function handle()
    {
        $this->info('Starting CyberAdmin Dashboard Installation...');
        $this->newLine();

        try {
            $this->steps = [];
            
            $this->step('Check and install dependencies (Livewire, Fortify)', function () {
                if (!class_exists('Livewire\Livewire')) {
                    $this->info('Livewire not found. Installing Livewire 4...');
                    $this->runShellCommand('composer require livewire/livewire:^4.0');
                } else {
                    $this->info('Livewire is already installed.');
                }
                
                if (!class_exists('Laravel\Fortify\FortifyServiceProvider')) {
                    $this->info('Fortify not found. Installing Laravel Fortify...');
                    $this->runShellCommand('composer require laravel/fortify');
                } else {
                    $this->info('Fortify is already installed.');
                }
                
                return true;
            });

            $this->step('Publish Fortify configuration', function () {
                if (!File::exists(config_path('fortify.php'))) {
                    $this->copyStubFile('config/fortify.php', config_path('fortify.php'));
                }
                return true;
            });

            $this->step('Publish authentication views', function () {
                $authViewPath = resource_path('views/auth');
                if (!File::isDirectory($authViewPath)) {
                    File::makeDirectory($authViewPath, 0755, true);
                }
                
                $stubs = ['login.blade.php', 'register.blade.php', 'forgot-password.blade.php', 'reset-password.blade.php'];
                foreach ($stubs as $stub) {
                    $this->copyStubFile("views/auth/{$stub}", "{$authViewPath}/{$stub}");
                }
                
                return true;
            });

            $this->step('Publish CyberAdmin configuration', function () {
                Artisan::call('cyberadmin:publish-config', [], $this->getOutput());
                return true;
            });

            $this->step('Publish CyberAdmin assets', function () {
                Artisan::call('cyberadmin:publish-assets', [], $this->getOutput());
                return true;
            });

            $this->step('Ensure storage link exists', function () {
                if (!File::exists(public_path('storage'))) {
                    Artisan::call('storage:link', [], $this->getOutput());
                }
                return true;
            });

            $this->step('Run database migrations', function () {
                $this->info('Running Laravel migrations...');
                Artisan::call('migrate', [], $this->getOutput());
                return true;
            });

            $this->newLine();
            $this->info('┌─────────────────────────────────────────────────────────────────────┐');
            $this->info('│  ✅  CyberAdmin Dashboard installed successfully!                     │');
            $this->info('└─────────────────────────────────────────────────────────────────────┘');
            $this->newLine();
            $this->info('Your dashboard is ready!');
            $this->info('Start your server and visit /cyberadmin');
            $this->newLine();

            return 0;
        } catch (\Exception $e) {
            $this->error('Installation failed! Rolling back changes...');
            $this->error('Error: ' . $e->getMessage());
            $this->rollback();
            return 1;
        }
    }

    protected function copyStubFile($stubPath, $destPath)
    {
        $source = __DIR__ . '/../../Stubs/' . $stubPath;
        if (File::exists($source)) {
            File::copy($source, $destPath);
            $this->info("  Copied: {$destPath}");
        }
    }

    protected function step($description, callable $callback)
    {
        $this->info("Step: {$description}");
        $result = $callback();
        if ($result !== false) {
            $this->steps[] = $description;
        }
        $this->newLine();
    }

    protected function rollback()
    {
        $this->warn('Rolling back completed steps...');
        foreach (array_reverse($this->steps) as $step) {
            $this->line("  - Rolling back: {$step}");
        }
        $this->warn('Rollback complete.');
    }

    protected function runShellCommand($command)
    {
        $output = [];
        $exitCode = 0;
        exec($command, $output, $exitCode);

        foreach ($output as $line) {
            $this->line($line);
        }

        if ($exitCode !== 0) {
            throw new \Exception("Command failed: {$command}");
        }
    }
}
