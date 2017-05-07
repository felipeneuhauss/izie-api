<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SimpleCrudCreator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:simple-crud {tableName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a simple CRUD table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function getArguments()
    {
        return func_get_args();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("CRUD created succefull");

        if ($tableName = $this->argument('tableName')) {
            $this->info("Syncing event $tableName");

//            return $this->client->syncEvent($eventId);
        }

    }
}
