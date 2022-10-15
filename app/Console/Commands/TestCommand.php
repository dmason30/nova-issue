<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'test:nova';

    protected $description = 'Command description';

    public function handle()
    {
        $versions = ['4.15.2', '4.16.0', '4.16.1'];

        foreach ($versions as $version) {
            $this->alert("Testing $version...");
            $this->info("Installing $version...");
            exec("composer require laravel/nova:$version 2> /dev/null");
            $this->info('Running tests...');
            passthru(base_path('vendor/bin/phpunit'));
        }
    }
}
