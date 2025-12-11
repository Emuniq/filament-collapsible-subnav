<?php

namespace Emuniq\FilamentCollapsibleSubnav\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    protected $signature = 'collapsible-subnav:install';
    protected $description = 'Install Filament Collapsible Subnav plugin into your theme';

    public function handle()
    {
        $this->info('Installing Filament Collapsible Subnav...');

        // Find theme CSS files
        $themeFiles = $this->findThemeFiles();

        if (empty($themeFiles)) {
            $this->comment('No Filament theme found. Plugin will work with default inline CSS.');
            $this->comment('For zero-flash experience, create a theme with: php artisan make:filament-theme');
            return 0;
        }

        $importLine = "@import '../../../../vendor/emuniq/filament-collapsible-subnav/resources/css/plugin.css';";

        foreach ($themeFiles as $themeFile) {
            $content = File::get($themeFile);

            // Check if already imported
            if (str_contains($content, 'filament-collapsible-subnav/resources/css/plugin.css')) {
                $this->comment("Already installed in: {$themeFile}");
                continue;
            }

            // Add import at the top (after any existing imports)
            $lines = explode("\n", $content);
            $insertIndex = 0;

            // Find last @import line
            foreach ($lines as $index => $line) {
                if (str_starts_with(trim($line), '@import')) {
                    $insertIndex = $index + 1;
                }
            }

            array_splice($lines, $insertIndex, 0, $importLine);
            $newContent = implode("\n", $lines);

            File::put($themeFile, $newContent);
            $this->info("✓ Added to: {$themeFile}");
        }

        $this->newLine();
        $this->warn('Remember to rebuild your assets:');
        $this->line('  npm run build');
        $this->newLine();
        $this->info('Installation complete!');

        return 0;
    }

    protected function findThemeFiles(): array
    {
        $files = [];
        $resourcePath = resource_path('css/filament');

        if (!File::isDirectory($resourcePath)) {
            return $files;
        }

        // Look for theme.css files in filament panel directories
        $panelDirs = File::directories($resourcePath);

        foreach ($panelDirs as $panelDir) {
            $themeFile = $panelDir . '/theme.css';
            if (File::exists($themeFile)) {
                $files[] = $themeFile;
            }
        }

        return $files;
    }
}
