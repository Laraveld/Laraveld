<?php

declare(strict_types=1);

namespace Laraveld\Laraveld;

use Laraveld\Laraveld\Commands\Setup\InstallationCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaraveldServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laraveld')
                ->hasCommands([
                    InstallationCommand::class,
                ]);
    }
}