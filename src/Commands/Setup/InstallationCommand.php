<?php

declare(strict_types=1);

namespace Laraveld\Laraveld\Commands\Setup;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laraveld\Laraveld\Repositories\ConfigurationRepository;

class InstallationCommand extends Command
{
    protected $signature = 'laraveld:install';

    public function handle(ConfigurationRepository $configurationRepository)
    {
        $this->output->title('Laraveld installation');

        $dashboardPath = $this->ask('Where do you want to install the dashboard?', 'dashboard');

        /**
         * Verify if the dashboard path is not already used
         * by another route.
         */
        $applicationRoutes = Route::getRoutes()->get('GET');
        if (array_key_exists($dashboardPath, $applicationRoutes)) {
            $this->output->error('The given path is already in use by another route in your application.');

            return self::FAILURE;
        }

        $dashboardPath = Str::of($dashboardPath)
            ->lower()
            ->kebab()
            ->finish('/')
            ->start('/');

        /**
         * Grab the configuration file stub
         * and replace the placeholders with
         * the users input.
         *
         * Then save the file in the applications
         * config directory.
         */
        $this->output->text('Publishing configuration file...');

        $stubsFilesystem = Storage::build($configurationRepository->get('filesystems.laraveld_stubs'));
        $projectConfigFilesystem = Storage::build($configurationRepository->get('filesystems.project_config'));

        $configurationStub = $stubsFilesystem->get('Laraveld.php.text');
        $configuration = Str::of($configurationStub)
            ->replace(':dashboard_path', $dashboardPath)
            ->toString();

        $projectConfigFilesystem->put('laraveld.php', $configuration);

        return self::SUCCESS;
    }
}
