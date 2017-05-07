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
class GenerateSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:generate-seeder {tableName?}';

    protected $modelList = array();

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a seeder based on a table name of MySQL database';

    private $howMuch = 100;

    private $faker = '';


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
        $this->info("------------------ GENERATE SEEDER ------------------");

        $tableName = $this->argument('tableName');

        try {

            if (!is_null($tableName)) {
                $this->howMuch = $this->ask('Deseja gerar quantos registros?', 100);
                $this->generateSeeder($tableName);
                $this->info("Seeder $tableName generate");
            }

            if (!$tableName) {
                $tables = DB::select("SHOW TABLES");
            }

            # Caso nao tenha sido passado o nome de uma tabela especifica
            if (is_null($tableName)) {
                $paramName = "Tables_in_".env('DB_DATABASE');

                $bar = $this->output->createProgressBar(count($tables));

                foreach ($tables as $table) {
                    if ($table->$paramName != 'DOCTYPES' && strpos($table->$paramName , 'MDRT_') !== 0) {
                        $this->info("Creating (" . $table->$paramName . ") model");
                        $this->howMuch = $this->ask('Deseja gerar quantos registros?', 100);
                        $this->generateSeeder($table->$paramName);
                        $bar->advance();
                    }
                }
                $bar->finish();
            }

//            $this->saveModelsToFile();

            $this->warn('--------------------- Fakers -------------------');

            $this->comment($this->faker);

            $this->comment("All complete");

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        return $this->info('Models customized. End.');

    }

    /**
     * Funcao que cria a model referente a uma tabela e tambem cria seus relacionamentos
     * @param $tableName
     */
    public function generateSeeder($tableName) {

        // Get model file
        $className   = str_plural($this->prepareModelName($tableName));

        $className .= "TableSeeder";

        $modelName   = $this->prepareModelName($tableName);

        $this->generateFaker($tableName);

        $classNameScope = "class $className extends Seeder";

        $callFactoryName = "factory(\\App\\Models\\$modelName::class, $this->howMuch)->create();";

        $fileContent = <<<EOL
<?php

use Illuminate\Database\Seeder;



$classNameScope
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $callFactoryName
    }

}
EOL;
        $this->modelList[$className] = $fileContent;
    }

    /**
     * Prepare a model name based in table name
     *
     * @param $tableName
     * @return string
     */
    public function prepareModelName($tableName)
    {
        $modelName = trim(ucfirst(str_singular($tableName)));

        if (strpos($tableName, '_') !== 0) {
            $modelNameExplodeList = explode('_', strtolower($tableName));

            $newModelName = '';
            foreach($modelNameExplodeList as $kName => $name) {
                $newModelName .= ucfirst(trim(str_singular($name)));
            }

            $modelName = $newModelName;
        }

        return $modelName;
    }


    /**
     * Salva todas as models carregadas
     */
    private function saveModelsToFile()
    {
        foreach($this->modelList as $modelName => &$content) {
            $fileName = __DIR__ . '/../../../database/seeds/'.$modelName. '.php';
            file_put_contents($fileName, $content);
            $this->info('Created class in '.$fileName);
        }
    }

    private function generateFaker($tableName)
    {
        $modelName = $this->prepareModelName($tableName);
        $columns = DB::select("SELECT *
                FROM information_schema.columns
                WHERE table_schema = '".env('DB_DATABASE', 'forge')."' AND table_name = '$tableName'");

        $this->faker = <<<FKR
            \$factory->define(App\Models\\$modelName::class, function (Faker\Generator \$faker) { \n
                \$yesOrNot =  array('Sim', 'Não'); \n
return [
FKR;
        foreach($columns as $column) {
            $this->buildFakerField($column);
        }
        $this->faker .= <<<FKR
    ];
        }); 

FKR;

    }


    public function buildFakerField($column) {

        if (!in_array($column->COLUMN_NAME, ['id', 'created_at', 'deleted_at', 'updated_at'])) {
            switch ($column->COLUMN_NAME) {
                case strpos($column->COLUMN_NAME, 'email') !== false :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->email,\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'name') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->name,\n";
                    break;
                case (strpos($column->COLUMN_NAME, '_at') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->date,\n";
                    break;
                case (strpos($column->COLUMN_NAME, '_at') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->date,\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'observation') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->text(200),\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'description') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->text(200),\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'detail') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->text(200),\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'quantity') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->numberBetween(1,500),\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'is_') !== false || strpos($column->COLUMN_NAME, 'has_') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$yesOrNot[rand(0,1)],\n";
                    break;
                case (strpos($column->COLUMN_NAME, '_id') !== false && strpos($column->COLUMN_NAME, 'city_id') === false) :
                    $this->faker .= "'$column->COLUMN_NAME' => rand(1,50),\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'cnpj') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->numerify('##.###.###/####-##'),\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'cpf') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->numerify('###.###.###-##'),\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'zip_code') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->postcode,\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'city_id') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->numberBetween(1,5000),\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'phone') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->phoneNumber,\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'fantasy_name') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->companySuffix,\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'social_name') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->company,\n";
                    break;
                case (strpos($column->COLUMN_NAME, 'volume') !== false || strpos($column->COLUMN_NAME, 'value') !== false) :
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->numerify('###.##'),\n";
                    break;
                default:
                    $this->faker .= "'$column->COLUMN_NAME' => \$faker->name,\n";
                    break;

            }
        }
    }

}
