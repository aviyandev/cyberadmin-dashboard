<?php

namespace CyberAdmin\Dashboard\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PublishCyberAdminConfig extends Command
{
    protected $signature = 'cyberadmin:publish-config {--force : Overwrite existing configuration file}';
    protected $description = 'Publish CyberAdmin Dashboard configuration file';

    public function handle()
    {
        $this->info('Publishing CyberAdmin Dashboard configuration...');

        $sourcePath = __DIR__ . '/../../Config/cyberadmin.php';
        $destPath = config_path('cyberadmin.php');

        if (!File::exists($sourcePath)) {
            $this->error("Source configuration file not found: {$sourcePath}");
            return 1;
        }

        if (File::exists($destPath) && !$this->option('force')) {
            if (!$this->confirm('Configuration file already exists. Overwrite?', false)) {
                $this->info('Configuration publishing cancelled.');
                return 0;
            }
        }

        File::copy($sourcePath, $destPath);
        $this->info('✅ Configuration file published successfully!');
        $this->line("  Location: {$destPath}");
        return 0;
    }
}
