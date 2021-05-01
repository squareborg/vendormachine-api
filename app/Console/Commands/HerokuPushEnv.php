<?php

namespace App\Console\Commands;

use Sqware\Heroku\HerokuPutEnvAdaptor;
use Illuminate\Console\Command;
use Dotenv;
class HerokuPushEnv extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'heroku:pushenv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pushes the .env.heroku to Heroku';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $heroku = new \Sqware\HerokuClient\Client([
            'apiKey' => 'my-api-key', // Or set the HEROKU_API_KEY environmental variable
        ]);
        $this->info('Pushing the env to heroku');
        $repository = Dotenv\Repository\RepositoryBuilder::create()
            ->withReaders([
                new HerokuPutEnvAdaptor(),
            ])
            ->withWriters([
                new HerokuPutEnvAdaptor(),
            ])
            ->make();

        $dotenv = Dotenv\Dotenv::create($repository, base_path(), '.env.heroku');
        $dotenv->load();
        // $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__, '.env.heroku');
    }
}
