<?php

namespace Kwhorne\WirementBreeze\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wirement-breeze:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install script for Wirement Breeze.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line('***************************');
        $this->line('*    WIREMENT BREEZE    *');
        $this->line('***************************');
        $this->newLine(2);
        if ($this->confirm('Do you want to enable Two Factor Authentication? (This will publish a new migration)', true)) {
            $this->callSilent('vendor:publish', [
                '--tag' => 'wirement-breeze-migrations',
            ]);
            if ($this->confirm('Do you want to run migrations now?', true)) {
                $this->call('migrate');
                $this->info('You may now enable 2FA by appending ->enableTwoFactorAuthentication() to WirementBreezeCore::make(). See the docs for more info.');
            } else {
                $this->warn('You must run migrations before using Wirement Breeze.');
            }
        }
        $this->newLine();
        if ($this->confirm('All done! Would you like to show some love by starring Wirement Breeze on GitHub?', true)) {
            if (PHP_OS_FAMILY === 'Darwin') {
                exec('open https://github.com/kwhorne/wirement-breeze');
            }
            if (PHP_OS_FAMILY === 'Linux') {
                exec('xdg-open https://github.com/kwhorne/wirement-breeze');
            }
            if (PHP_OS_FAMILY === 'Windows') {
                exec('start https://github.com/kwhorne/wirement-breeze');
            }

            $this->components->info('Thank you!');
        }

        return static::SUCCESS;
    }
}
