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
class CreateFormFields extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-form-fields {tableName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a form with all fields, show the factory';

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
        $this->info("------------------ CUSTOMIZE FORM ------------------");

        $tableName = $this->argument('tableName');

        try {

            if ($tableName) {
                $this->generateFormFields($tableName);
                $this->info("$tableName generated");
            }

        } catch (Exception $e) {
            $this->error('File:'.$e->getFile().'|Linha:'.$e->getLine().'|Message:'.$e->getMessage());
        }

    }

    public function generateFormFields($tableName) {
        $columns = DB::select("SELECT *
                FROM information_schema.columns
                WHERE table_schema = '".env('DB_DATABASE', 'forge')."' AND table_name = '$tableName'");

        // Get model file

        $fileName = __DIR__ . '/../../../resources/forms/'.$tableName.'-'.time().'-fields.blade.php';

        $title = $this->ask('Título do form?');
        $formUrl = $this->ask('URL do form?', str_replace('_', '-', $tableName).'/form');
        $formId = $this->ask('ID do form?', str_replace('_', '-', $tableName));
        $instructions = $this->ask('Instruções do form?', 'incluir toda e qualquer informação correspondente ao tema, considerada relevante para os propósitos da metodologia.');

        $fileContent = <<<EOF
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>$title</h2>
            <small class="text-muted">$instructions</small>
        </div>
        @include('layouts.messages', array('errors' => \$errors,
                                  'messages' => Session::get('messages')))
        <div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>Basic Information <small>Description text here...</small> </h2>
						<ul class="header-dropdown m-r--5">
							<li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-more-vert"></i></a>
								<ul class="dropdown-menu pull-right">
									<li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
									<li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
									<li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="body">
					{!! Form::open(array('url' => '$formUrl', 'id' => '$formId' , 'class' => 'form-validate')) !!}
EOF;
;

        $modelFakerName = $this->prepareModelName($tableName);
        $this->faker = <<<FKR
            \$factory->define(App\Models\\$modelFakerName::class, function (Faker\Generator \$faker) { \n
                \$yesOrNot =  array('Sim', 'Não'); \n
return [
FKR;

        $count = 0;
        foreach($columns as $key => &$column) {
            try {
                $if = '';
                $attrs = explode('|', $column->COLUMN_COMMENT);

                $column->COLUMN_COMMENT = $attrs[0];
                if (count($attrs)) {
                    foreach ($attrs as $attr) {
                        if (strpos($attr, 'if:') !== false) {
                            $ifCondition = explode(':', $attr);
                            $if = $ifCondition[0].'="'.$ifCondition[1].'"';
                        }
                    }
                }

                # Build the faker
                $this->buildFakerField($column);

                if (!in_array($column->COLUMN_NAME, array('id', 'created_at', 'updated_at', 'deleted_at', 'user_id', 'remember_token'))) {
                    if ($column->COLUMN_COMMENT == "") {
                        $column->COLUMN_COMMENT = $this->ask('Qual o nome do campo '.$column->COLUMN_NAME.' ?');
                    }
                    $this->info($column->COLUMN_NAME . '|' . $column->DATA_TYPE);
                    if ($count == 0) {
                        $fileContent .= <<<EOF
                    <div class="row clearfix">
EOF;
                    }

                    $required = ($column->IS_NULLABLE == 'NO') ? '<span class="asterisk">*</span>' : '';
                    $fileContent .= <<<EOF
                            <div class="col-sm-3 col-xs-3" $if>
                                <div class="form-group">
                                    <div class="form-line">
                                
EOF;
                    $name = $column->COLUMN_NAME;
                    $id = $column->COLUMN_NAME;
                    $class = 'form-control';
                    $class .= ($column->IS_NULLABLE == 'NO') ? ' required' : '';
                    $placeholder = $column->COLUMN_COMMENT;

                    if ($column->DATA_TYPE == 'timestamp') {
                        $class .= ' datepicker';
                    }

                    if (strpos($column->COLUMN_NAME, 'zip_code') !== false) {
                        $class .= ' cep';
                    }

                    if (strpos($column->COLUMN_NAME, 'cpf') !== false) {
                        $class .= ' cpf';
                    }

                    if (strpos($column->COLUMN_NAME, 'cnpj') !== false) {
                        $class .= ' cnpj';
                    }

                    if (strpos($column->COLUMN_NAME, 'phone') !== false) {
                        $class .= ' phone';
                    }

                    if (strpos($column->COLUMN_NAME, 'mail') !== false) {
                        $class .= ' email';
                    }

                    if ($column->DATA_TYPE == 'int') {
                        $class .= ' number';
                    }

                    if ($column->DATA_TYPE == 'double') {
                        $class .= ' money';
                    }

                    // Vefifica o tipo de campo
                    if ((strpos($column->DATA_TYPE, 'varchar') !== false || strpos($column->DATA_TYPE, 'int') !== false
                    || strpos($column->DATA_TYPE, 'double') !== false) && strpos($column->COLUMN_NAME, '_id') === false) {

                        $fileContent .= <<<EOL
        {!! Form::text('$name', \$vo->$name, ['class' => '$class', 'id' => '$id', 'placeholder' => '$placeholder']) !!}
EOL;
                        $count++;
                    }

                    if (strpos($column->DATA_TYPE, 'text') !== false) {

                        $fileContent .= <<<EOL
        {!! Form::textarea('$name', \$vo->$name, ['class' => '$class', 'id' => '$id', 'placeholder' => '$placeholder']) !!}
            
EOL;
                        $this->warn('text');
                        $count++;
                    }


                    if (strpos($column->DATA_TYPE, 'enum') !== false) {
                        $columnOptions = str_replace("'", '', str_replace(')', '', str_replace('enum(', '', $column->COLUMN_TYPE)));

                        if (strpos($columnOptions, ',') !== false) {
                            $keys = explode(',', $columnOptions);
                        }
                        $options = array();
                        foreach ($keys as $option) {
                            $options[] = "'$option'  => '$option' ";
                        }

                        $options = implode(',', $options);

                        $fileContent .= <<<EOL
            {!! Form::select('$name', array($options), \$vo->$name, ['placeholder' => 'Selecione...', 'class' => '$class', 'id' => '$name']) !!}
EOL;
                        $count++;
                    }

                    if (strpos($column->COLUMN_NAME, '_id') !== false) {
                        $this->error($column->COLUMN_NAME);
                        $columnOptions = array();
                        $foreignColumn = str_replace("_id", '', $column->COLUMN_NAME);

                        if (strpos($foreignColumn, '_') !== false) {
                            $columnOptions = explode('_', $foreignColumn);
                        }

                        $optionsName = '';

                        if (count($columnOptions)) {
                            foreach ($columnOptions as $k => $str) {
                                if ($k == 0) {
                                    $optionsName .= $str;
                                } else {
                                    $optionsName .= ucfirst($str);
                                }
                            }
                        } else {
                            $optionsName = $foreignColumn;
                        }

                        $optionsName = str_plural($optionsName);

                        $fileContent .= <<<EOL
                        {!! Form::select('$name', \$$optionsName, \$vo->$name, ['placeholder' => '$placeholder', 'class' => '$class' , 'id' => '$name']) !!}

EOL;
                        $count++;
                    }

                    $fileContent .= <<<EOL
                                    </div>
                                </div>
                            </div>
EOL;

                    if ($count == 3) {
                        $fileContent .= <<<EOF
                    </div>
                            
EOF;
                        $count = 0;
                    }
                }
            } catch (Exception $e) {
                $this->error('File:'.$e->getFile().'|Linha:'.$e->getLine().'|Message:'.$e->getMessage());
            }
        }

        if ($count < 3) {
            $fileContent .= <<<EOF
                    </div>
EOF;
        }
        
        $fileContent .= <<<EOF
                            <div class="col-xs-12">
                                {!! Form::hidden('id', \$vo->id) !!}
                                <button type="submit" class="btn btn-raised g-bg-cyan">Submit</button>
                                <button type="button" class="btn btn-raised">Cancel</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
				</div>
			</div>
		</div>
</section>
EOF;

        $this->faker .= <<<FKR
    ];
        }); 

FKR;

        $this->warn('----------------------------------------------------------------');
        $this->comment($this->faker);

        file_put_contents($fileName, $fileContent);
        $this->info('Created form in '.$fileName);

    }

    public function buildFakerField($column) {

        $this->comment($column->COLUMN_NAME.':faker');
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
            $this->warn($column->COLUMN_NAME.':faker:after');
        }
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

}
