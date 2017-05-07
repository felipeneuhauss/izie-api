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
class CreateController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:create-controller {tableName?}';

    protected $modelList = array();

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a controller based into a table name of MySQL database';

    protected $timestamp = true;

    private $softDelete = true;

    private $abstractModelName = 'AppController';


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
        $this->info("------------------ CUSTOMIZE CONTROLLER ------------------");

        $tableName = $this->argument('tableName');

        # Obtem as tabelas do banco
        if (!$tableName) {
            $tables = DB::select("SHOW TABLES");
        }

        if ($this->confirm('A model irá extender alguma outra classe?', true)) {
            $this->abstractModelName = $this->ask('Qual o nome da classe a ser extendida?', $this->abstractModelName);
        } else {
            $this->abstractModelName = "";
        }

        try {

            if ($tableName) {
                $this->generateController($tableName);
                $this->info("Model $tableName customized");
            }

            # Caso nao tenha sido passado o nome de uma tabela especifica
            if (!$tableName) {
                $paramName = "Tables_in_".env('DB_DATABASE');

                $bar = $this->output->createProgressBar(count($tables));

                foreach ($tables as $table) {
                    if ($table->$paramName != 'DOCTYPES' && strpos($table->$paramName , 'MDRT_') !== 0) {
                            $this->info("Creating " . $table->$paramName . " model");
                            $this->generateController($table->$paramName);
                        $bar->advance();
                    }
                }
                $bar->finish();
            }

            $this->saveControllersToFile();

            $this->comment("All complete");

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        return $this->info('Controllers customized. End.');

    }

    /**
     * Funcao que cria a model referente a uma tabela e tambem cria seus relacionamentos
     * @param $tableName
     */
    public function generateController($tableName) {

        // Get model file
        $modelName   = $this->prepareModelName($tableName);

        $columns = $this->getColumns($tableName);

        $fkColumns = $this->getFkColumns($tableName);

        // Obtem o nome das colunas das tabelas ferenciais
        $fkColumnsName = [];
        foreach ($fkColumns as $fkColumn) {
            $fkColumnsName[] = lcfirst($this->prepareModelName($fkColumn->TABLE_NAME));
        }

        $fkColumnsName = implode("','", $fkColumnsName);
        $fkColumnsName = ($fkColumnsName != "") ? "'".$fkColumnsName."'" : "";

        $dependentColumns = $this->getDependentFkColumns($tableName);

        $primaryKeyName = 'id';

        $fillableColumnsName = array();
        if (count($columns)) {
            foreach($columns as $column) {
                $fillableColumnsName[] = $column->column_name;
            }
        }

        # Gera o nome das colunas do campo fillable
        $columnsName = strtolower(implode("','", $fillableColumnsName));

        $controllerClassName = $modelName.'Controller';
        # Configura o nome da classe, extend e implementation
        $classNameScope = "class $controllerClassName extends $this->abstractModelName";

        $viewFolderName = str_replace('_', '-', $tableName);

        $fileContent = <<<EOL
<?php

namespace App\Http\Controllers\\$modelName;

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
use App\Models\\$modelName;
use Request;

$classNameScope
{
     public function __construct() {
        parent::__construct();
        \$this->middleware('auth');
        \$this->repository = new Repository(new $modelName());
        \$this->viewFolderName = '$viewFolderName';
    }

EOL;
        $validation = $this->generateValidation($tableName);

        $fileContent .= <<<EOL
    /**
     * Get a validator for an incoming registration request.
     *
     * @param \App\Models\Contracts\InterfaceModel  \$vo
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function _validate(\$vo)
    {
        $validation
    }

    protected function _preSave(\$vo) {
        if (!\$vo->id) {
            \$vo->user_id = Auth::user()->id;
        }
    }

    protected function _initForm(\$vo = null)
    {
        return array('vo' => \$vo);
    }
EOL;

        $fileContent .= $this->generatePostSaveFunction($tableName);

//        $fileContent .= $this->generateBelongsToFunctions($fkColumns, $modelName);
//
//        $fileContent .= $this->generateHasManyModelFunctions($dependentColumns, $modelName);

        $fileContent .= <<<EOL

}
EOL;
        $this->modelList[$modelName] = $fileContent;
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
     * Retorna as chves extrangeiras de uma tabela
     * @param $tableName
     * @return mixed
     */
    private function getFkColumns($tableName)
    {
        $fkColumns = DB::select("SELECT DISTINCT
              TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
            FROM
              INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE
              TABLE_NAME = '$tableName' AND CONSTRAINT_NAME != 'PRIMARY' and REFERENCED_TABLE_NAME is not null");

        return $fkColumns;
    }

    /**
     * Retorna as tabelas dependentes do
     * @param $tableName
     * @return mixed
     */
    private function getDependentFkColumns($tableName)
    {

        $dbName = env('DB_DATABASE');
        $fkColumns = DB::select("SELECT *
FROM  INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE
  REFERENCED_TABLE_NAME = '$tableName' 
  AND TABLE_SCHEMA = '$dbName' 
  AND CONSTRAINT_NAME != 'PRIMARY'");

        return $fkColumns;
    }

    /**
     * Retorna a chave primaria da tabela
     * @param $tableName
     * @return mixed
     */
    private function getPkColumnName($tableName)
    {
        $column = DB::select("SELECT DISTINCT column_name FROM all_cons_columns WHERE constraint_name = (
          SELECT constraint_name FROM all_constraints
          WHERE UPPER(table_name) = UPPER('$tableName') AND CONSTRAINT_TYPE = 'P'
            )");

        if (count($column)) {
            return $column[0]->column_name;
        }
    }

    /**
     * Salva todas as models carregadas
     */
    private function saveControllersToFile()
    {
        foreach($this->modelList as $modelName => &$content) {
            $fileName = __DIR__ . '/../../Http/Controllers/'.$modelName;
            if (!is_dir($fileName)) {
                mkdir($fileName);
            }

            $fileName .= '/'.$modelName. 'Controller.php';

            file_put_contents($fileName, $content);
            $this->warn('Created class in '.$fileName);
        }
    }

    private function generateBelongsToFunctions($fkColumns, $modelName)
    {
        $fileContent = '';

        if (count($fkColumns)) {

            foreach ($fkColumns as &$fkColumn) {
                # BelongTo relationship
                $relationalTableName = $fkColumn->REFERENCED_TABLE_NAME;
                $relationalModelName = $this->prepareModelName($relationalTableName);
                $relationalPkName = strtolower($fkColumn->REFERENCED_COLUMN_NAME);
                $localFkName      = strtolower($fkColumn->COLUMN_NAME);

                // Configura  o nome da funcao e nome da model
                $belongToFunctionName = lcfirst($relationalModelName);
                $modelRelationName = "App\\Models\\" . $relationalModelName;
                $this->info($modelName . ' belongsTo ' . $relationalModelName);

                $fileContent .= <<<EOL

    public function $belongToFunctionName() 
    {
        return \$this->belongsTo('$modelRelationName', '$localFkName', '$relationalPkName');
    }

EOL;
            }
        }
        return $fileContent;
    }


    /**
     * Gera as funcoes relacionadas de um para muitos 'hasMany'
     *
     * @param $dependentColumns
     * @param $tableName
     * @return string
     */
    public function generateHasManyModelFunctions($dependentColumns, $tableName)
    {
        // Get model file
        $fileContent = '';
        if (count($dependentColumns)) {
            foreach ($dependentColumns as $column) {

                $modelRelationName = $this->prepareModelName($column->TABLE_NAME);
                $modelRelationClassName = "App\\Models\\" . $modelRelationName;

                $hasManyFunctionName = str_plural(lcfirst($modelRelationName));
                $this->info($tableName . ' hasMany ' . $modelRelationName);


                $fkName = strtolower($column->COLUMN_NAME);
                $pkRelationalName = strtolower($column->REFERENCED_COLUMN_NAME);

                /**
                 * Obtem o arquivo referente a coluna para add o hasMany() na classe pai
                 */

                $fileContent .= <<<EOL

    public function $hasManyFunctionName()
    {
        return \$this->hasMany('$modelRelationClassName', '$fkName', '$pkRelationalName');
    }

EOL;
            }
        }
        return $fileContent;

    }


    public function getColumns($tableName) {
        return DB::select("SELECT column_name AS column_name
                FROM information_schema.columns
                WHERE table_schema = '".env('DB_DATABASE', 'forge')."' AND table_name = '$tableName'");
    }

    public function generateValidation($tableName) {
        $this->info("Customizing validation");

        $tableInfo = DB::select("SELECT *
                FROM information_schema.columns
                WHERE table_schema = '".env('DB_DATABASE', 'forge')."' AND table_name = '$tableName'");

        $validateReturnString =  "return Validator::make(Request::all(), [";
        $reservedColumns = array('id', 'updated_at', 'created_at', 'deleted_at');
        $validationDefinitionList = [];
        $validationMessages = "";
        $validationDefinitionString = "";

        foreach ($tableInfo as $columnInfo) {
            $validationDefinitionList = [];

            if (!in_array($columnInfo->COLUMN_NAME, $reservedColumns)) {

//                $name = $this->ask('Qual o nome do campo em português para a mensagem?');

                // Por tipo de campo
                if ($columnInfo->IS_NULLABLE == "NO") {
                    // 'fantasy_name.required'         => 'O campo Nome fantasia é obrigatório.',
                    $validationMessages .= "        '$columnInfo->COLUMN_NAME.required' => 'O campo ".ucfirst($columnInfo->COLUMN_COMMENT). " é obrigatório', \n";
                    // 'name'                      => 'required|max:255',
                    $validationDefinitionList[] = "required";
                }

                if (strpos($columnInfo->COLUMN_TYPE, "varchar") !== false) {
                    $validationDefinitionList[] = "max:".get_numerics($columnInfo->COLUMN_TYPE)."";
                    $validationMessages .= "        '$columnInfo->COLUMN_NAME.max' => 'O campo ".ucfirst($columnInfo->COLUMN_COMMENT). " deve ter no máximo ".get_numerics($columnInfo->COLUMN_TYPE)." caracteres', \n";
                }

                if (strpos($columnInfo->COLUMN_TYPE, "int") !== false) {
                    $validationDefinitionList[] = "integer";
                    $validationMessages .= "        '$columnInfo->COLUMN_NAME.integer' => 'O campo ".ucfirst($columnInfo->COLUMN_COMMENT). " deve ser um número inteiro', \n";
                }

                if (strpos($columnInfo->COLUMN_TYPE, "timestamp") !== false) {
                    $validationDefinitionList[] = "date";
                    $validationMessages .= "        '$columnInfo->COLUMN_NAME.date' => 'O campo ".ucfirst($columnInfo->COLUMN_COMMENT). " deve ser uma data válida', \n";
                }

                // Por nome de campo
                if (strpos($columnInfo->COLUMN_NAME, "email") !== false) {
                    $validationDefinitionList[] = "email";
                    $validationMessages .= "        '$columnInfo->COLUMN_NAME.date' => 'O campo ".ucfirst($columnInfo->COLUMN_COMMENT). " deve ser um e-mail válido', \n";
                }

                if (count($validationDefinitionList)) {
                    $validationDefinitionString .= "        '$columnInfo->COLUMN_NAME' => '".implode('|', $validationDefinitionList)."', \n";
                }
            }
        }
        $validateReturnString .= $validationDefinitionString . "        ],\n        [ \n";

        $validateReturnString .= $validationMessages ."     ]);";

        return $validateReturnString;
    }

    public function generatePostSaveFunction($tableName) {
        $content = <<<EOL
        
    protected function _postSave(\$vo) 
    {
EOL;
        $columns = (array) $this->getDependentFkColumns($tableName);
        $tables = [];
        foreach ($columns as $column) {
            $tables[] = $column->TABLE_NAME;
        }

        $tables[] = 'Ok, selecionei tudo.';

        $manyToManyTables = [];
        do {

            $table = $this->choice(
            'Quais tabelas são N para N?',
                $tables
            );
            // Remove a opcao escolhida
            $arrayKey = array_keys($tables, $table);

            unset($tables[$arrayKey[0]]);

            $manyToManyTables[] = $table;

        } while ($table != 'Ok, selecionei tudo.');

        array_pop($manyToManyTables);
        $this->comment("Source chosen is ".implode(',', $manyToManyTables));

        $vars = [];
        foreach ($manyToManyTables as $k => $table) {
            $vars[$k]['table'] = $table;
            $targetModel = str_plural($table);
            $fieldName = str_plural(str_replace(str_singular($tableName).'_', '', $table));
            $vars[$k]['model_name'] = $this->prepareModelName($targetModel);
            $vars[$k]['field_name'] = $fieldName;
            $vars[$k]['fk_pivot_id'] = str_singular($fieldName).'_id';
            $vars[$k]['pk_pivot_id'] = str_singular($tableName).'_id';
        }

        # Nome da model pivo - ok
        # nome da tabela pivo - ok
        # Nome da variael que vem do post (nome do campo no plural) - ok
        # nome da variavel da chave estrangeira na tabela pivo
        # nome da variavel da chave primaria na tabela pivo

        // Arrepia criando as relacoes
        foreach ($vars as $var) {

            $modelPivot = $var['model_name'];
            $pkPivotId  = $var['pk_pivot_id'];
            $fkPivotId  = $var['fk_pivot_id'];
            $fieldName  = $var['field_name'];
            $pivotTableName  = $var['table'];
            $iteratorVar = str_singular($var['field_name']);

            $content .= <<<EOL
            
            $$fieldName = Request::input('$fieldName');
            
            \App\Models\\$modelPivot::where('$pkPivotId', \$vo->id)->delete();
            foreach ($$fieldName as $$iteratorVar) {
                if ($$iteratorVar != "") {
                    DB::table('$pivotTableName')->insert([
                        '$fkPivotId' => $$iteratorVar,
                        '$pkPivotId' => \$vo->id,
                    ]);
                }
            }
EOL;
        }


        $content .= <<<EOL
        
    }
EOL;

        return $content;
    }
}
