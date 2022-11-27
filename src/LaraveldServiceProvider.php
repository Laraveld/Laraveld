<?php

declare(strict_types=1);

namespace Laraveld\Laraveld;

use Laraveld\Laraveld\Commands\Setup\InstallationCommand;
use Laraveld\Laraveld\Repositories\ConfigurationRepository;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaraveldServiceProvider extends PackageServiceProvider
{
    private ConfigurationRepository $configurationRepository;

    public function __construct($app)
    {
        parent::__construct($app);

        $this->configurationRepository = resolve(ConfigurationRepository::class);
    }

    public function configurePackage(Package $package): void
    {
        $package->name('laraveld')->hasCommands([
            InstallationCommand::class,
        ]);

        /**
         * Configure internal package configurations.
         */
        $this->configurationRepository->set('filesystems.laraveld_stubs', [
            'driver' => 'local',
            'root' => __DIR__.'/../stubs',
        ]);
        $this->configurationRepository->set('filesystems.project_config', [
            'driver' => 'local',
            'root' => config_path(),
        ]);
    }
}
