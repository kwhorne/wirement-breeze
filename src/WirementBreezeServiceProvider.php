<?php

namespace Kwhorne\WirementBreeze;

use Kwhorne\WirementBreeze\Commands\Install;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WirementBreezeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('wirement-breeze')
            ->hasRoute('web')
            ->hasViews()
            ->hasTranslations()
            // ->hasMigration('add_two_factor_columns_to_table')
            ->hasMigration('create_wirement_breez_sessions_table')
            ->hasCommand(Install::class);
    }
}
