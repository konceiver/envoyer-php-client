<?php

declare(strict_types=1);

/*
 * This file is part of Skeleton.
 *
 * (c) Konceiver Oy <info@konceiver.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Konceiver\Skeleton\Providers;

use Illuminate\Support\ServiceProvider;

class SkeletonServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/skeleton.php', 'skeleton');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadViewsFrom(__DIR__.'/../../resources/views', 'skeleton');

            $this->publishes([
                __DIR__.'/../../config/skeleton.php' => $this->app->configPath('skeleton.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../../database/migrations/create_some_table.stub' => $this->getMigrationPath('create_some_table'),
            ], 'migrations');

            $this->publishes([
                __DIR__.'/../../resources/views' => $this->app->resourcePath('views/vendor/skeleton'),
            ], 'views');
        }
    }

    private function getMigrationPath(string $file): string
    {
        $timestamp = date('Y_m_d_His');

        return $this->app->databasePath("/migrations/{$timestamp}_{$file}.php");
    }
}
