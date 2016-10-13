<?php

namespace App\Console\Commands\Deploy;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy project';

    /**
     * Create a new command instance
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('git pull');
        exec('git checkout master');
        exec('git pull');
        exec('composer dump-autoload');

        $this->info('Execute migration');
        Artisan::call('migrate');

        $this->info('run php tests');
        $test = new Process('phpunit --color=always');
        $test->run();
        $response = $test->getOutput();
        if (strpos($response, 'FAILURES!') !== false) {
            $this->error('Unit test failed!');
            $this->info($response);

            $this->info('git pull rollback');
//            exec('git reset --hard');
            exec('composer dump-autoload');

            $this->info('Execute migration rollback');
            Artisan::call('migrate');
        } else {
            $this->info('Caching routes, providers');
            Artisan::call('route:cache');

            $this->info('Caching config');
            Artisan::call('config:cache');

            $this->info('Optimizing framework');
            Artisan::call('optimize');

            exec('composer dump-autoload');
        }
    }
}
