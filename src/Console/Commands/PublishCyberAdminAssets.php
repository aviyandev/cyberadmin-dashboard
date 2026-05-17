<?php

namespace CyberAdmin\Dashboard\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PublishCyberAdminAssets extends Command
{
    protected $signature = 'cyberadmin:publish-assets';
    protected $description = 'Publish CyberAdmin Dashboard assets to public directory';

    public function handle()
    {
        $this->info('Publishing CyberAdmin Dashboard assets...');

        $sourcePath = __DIR__ . '/../../../resources';
        $destPath = public_path('vendor/cyberadmin');

        if (!File::isDirectory($sourcePath)) {
            $this->error("Source directory not found: {$sourcePath}");
            return 1;
        }

        if (!File::isDirectory($destPath)) {
            File::makeDirectory($destPath, 0755, true);
            $this->info("Created directory: {$destPath}");
        }

        $this->copyDirectory($sourcePath, $destPath);

        $this->info('✅ Assets published successfully!');
        return 0;
    }

    protected function copyDirectory($source, $dest)
    {
        if (!File::isDirectory($dest)) {
            File::makeDirectory($dest, 0755, true);
        }

        $files = File::files($source);
        foreach ($files as $file) {
            $destFile = $dest . '/' . $file->getFilename();
            File::copy($file->getPathname(), $destFile);
            $this->line("  Copied: {$file->getFilename()}");
        }

        $directories = File::directories($source);
        foreach ($directories as $dir) {
            $dirName = basename($dir);
            $this->copyDirectory($dir, $dest . '/' . $dirName);
        }
    }
}
