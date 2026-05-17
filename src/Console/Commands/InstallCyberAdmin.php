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

            $this->step('Check if Livewire is installed', function () {
                if (!class_exists('Livewire\Livewire')) {
                    $this->info('Livewire not found. Installing Livewire 4...');
                    $this->runShellCommand('composer require livewire/livewire:^4.0');
                    return true;
                }
                $this->info('Livewire is already installed.');
                return false;
            });

            $this->step('Publish configuration', function () {
                Artisan::call('cyberadmin:publish-config', [], $this->getOutput());
                return true;
            });

            $this->step('Publish assets', function () {
                Artisan::call('cyberadmin:publish-assets', [], $this->getOutput());
                return true;
            });

            $this->step('Ensure storage link exists', function () {
                if (!File::exists(public_path('storage'))) {
                    Artisan::call('storage:link', [], $this->getOutput());
                }
                return true;
            });

            $this->step('Run database migrations (if available)', function () {
                $migrationPath = __DIR__ . '/../../Database/Migrations';
                if (File::isDirectory($migrationPath) && count(File::files($migrationPath)) > 0) {
                    Artisan::call('migrate', [], $this->getOutput());
                }
                return true;
            });

            $this->newLine();
            $this->info('┌─────────────────────────────────────────────────────────────┐');
            $this->info('│  ✅  CyberAdmin Dashboard installed successfully!           │');
            $this->info('└─────────────────────────────────────────────────────────────┘');
            $this->newLine();
            $this->info('Next steps:');
            $this->line('  • Make sure you have a user authentication system set up');
            $this->line('  • Visit /cyberadmin to access the dashboard');
            $this->line('  • Use php artisan cyberadmin:publish-config to customize settings');
            $this->newLine();

            return 0;
        } catch (\Exception $e) {
            $this->error('Installation failed! Rolling back changes...');
            $this->error('Error: ' . $e->getMessage());
            $this->rollback();
            return 1;
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
