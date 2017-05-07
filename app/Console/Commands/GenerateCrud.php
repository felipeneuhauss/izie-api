<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


/**
 * Class responsible to generate a model or a set of models based in database tables
 * and configure your structure with interfaces and inheritance
 *
 * Class CustomizeModel
 * @package App\Console\Commands
 */
class GenerateCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate-crud {tableName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a CRUD';

    public $faker = '';

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
        $this->info("Getting table");

        $tableName = $this->argument('tableName');

        try {

            if ($tableName) {

                $this->call('make:create-model', [
                    'tableName' => $tableName
                ]);

                $this->call('make:create-controller', [
                    'tableName' => $tableName
                ]);

                $this->call('create-form-fields', [
                    'tableName' => $tableName
                ]);

            }

        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

    }

}
