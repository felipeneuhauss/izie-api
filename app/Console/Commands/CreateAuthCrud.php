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
class CreateAuthCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-auth-crud';

    protected $formContent = '';

    protected $indexContent = '';

    protected $userControllerContent = '';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD of auth';


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
        $this->info("Creating form");

        $this->formContent = <<<EOF
@extends('layouts.layout')

@section('content')

    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-user"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href=""><i class="glyphicon glyphicon-home"></i></a></li>
                    <li><a href="/users">Usuários</a></li>
                    <li>Cadastro de usuário</li>
                </ul>
                <h4>Cadastro de usuário</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">
        <div class="row">
            <div class="col-md-12">
                @include('layouts.messages', array('errors' => \$errors,
                                          'messages' => Session::get('messages')))

                {!! Form::open(array('url' => '/users/form', 'id' => 'processes-form' , 'class' => 'form-validate')) !!}
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nome<span class="asterisk">*</span></label>
                                <div class="col-sm-9">
                                    {!! Form::text('name', \$vo->name, ['class' => 'form-control required', 'id' => 'name', 'placeholder' => 'Nome']) !!}
                                </div>
                            </div>

                            <!-- form-group -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email<span class="asterisk">*</span></label>
                                <div class="col-sm-9">
                                    {{Form::email('email', \$vo->email, ['class' => 'form-control', 'placeholder'=> 'E-mail', 'disabled' => 'disabled'])}}
                                </div>
                            </div><!-- form-group -->

                            <!-- form-group -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Perfil<span class="asterisk">*</span></label>
                                <div class="col-sm-9">
                                    {!! Form::select('profile_id', \$profiles, \$vo->profile_id , ['id' => 'profile_id', 'placeholder' => 'Selecione...', 'class' => 'form-control required']) !!}
                                </div>
                            </div><!-- form-group -->
                        </div><!-- row -->
                    </div><!-- panel-body -->
                    <div class="panel-footer">
                        <div class="row">
                            {!! Form::hidden('id', \$vo->id) !!}
                            <div class="col-sm-9 col-sm-offset-3">
                                <a class="btn btn-info" href="/users">Voltar</a>
                                <button class="btn btn-success" type="submit">Enviar</button>
                            </div>
                        </div>
                    </div><!-- panel-footer -->
                </div><!-- panel -->
                {!! Form::close() !!}

            </div><!-- col-md-6 --><!-- col-md-6 -->
        </div><!--row -->

    </div><!-- contentpanel -->
    <script>

    </script>
@endsection

EOF;
        $this->info("Creating index");
        $this->indexContent = <<<EOF
@extends('layouts.layout')

@section('content')
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-users"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href=""><i class="glyphicon glyphicon-home"></i></a></li>
                    <li><a href="{{url('users')}}">Usuários</a></li>
                </ul>
                <h4>Usuários</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">
        <div class="row">
            @include('layouts.messages', array('errors' => \$errors,
                                          'messages' => Session::get('messages'), 'warnings' => Session::get('warnings')))
            <div class="content">
                <table id="example" class="table table-striped table-bordered">
                    <thead class="">
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if (count(\$data))
                        @foreach(\$data as \$vo)
                            <tr>
                                <td>{{\$vo->name}}</td>
                                <td>{{\$vo->email}}</td>
                                <td>{{\$vo->profile->name}}</td>
                                <td>
                                    <a class="btn btn-success" href="{{url('/users/form/'.\$vo->id)}}"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-danger delete" href="{{url('/users/remove/'.\$vo->id)}}"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">Nenhum registro encontrado</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="pull-right clearfix">{{ \$data->links()}}</div>
            </div>
        </div>

    </div>

@endsection

EOF;

        $this->userControllerContent = <<<EOF
<?php
/**
 * Created by PhpStorm.
 * User: felipeneuhauss
 * Date: 01/09/15
 * Time: 22:04
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AppController;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Request;

class UserController extends AppController
{

    /**
     * @var \App\Repositories\Eloquent\PaymentRepository
     */
    protected \$repository;

    public function __construct()
    {
        parent::__construct();
        \$this->middleware('auth', ['only' => ['form', 'index']]);
        \$this->repository = new Repository(new User());
        \$this->viewFolderName = 'users';
    }

    /**
     * @overwrite index
     * @return mixed
     */
    public function index() {

        \$result = \$this->repository->paginate(15);

        return view('auth.users.index', ['data' => \$result]);
    }


    /**
     * @param Request \$request
     * @return \$this
     */
    public function form(\$id = null)
    {
        if (is_null(\$id)) {
            \$id = Request::input('id') == null || Request::input('id') == '' ? null : Request::input('id');
        }
        
        \$vo = \$this->repository->findOrNew(\$id);

        if ((\$vo->profile_id <= auth()->user()->profile_id) && \$vo->id != auth()->user()->id) {
            \Session::flash('warnings', array('Você não tem permissão'));
            return redirect('/users');
        }

        if (!Auth::guest() && \$id) {

            \$validator = array();

            if (Request::isMethod('post')) {
                \$validator = \$this->_validate(\$vo);

                \$vo->fill(Request::all());

                if (!\$validator->fails()) {

                    if (Request::input('change')) {
                        \$vo->password = Hash::make(\$vo->password);
                    }

                    \$this->_preSave(\$vo);
                    \$vo->save();
                    \$this->_postSave(\$vo);

                    \Session::flash('messages', array('Seus dados foram salvos com sucesso!'));

                    if (\$this->redirectURL != "") {
                        return redirect(\$this->redirectURL);
                    }
                }
            }

            return view('auth.users.form', \$this->_initForm(\$vo))
                ->withErrors(\$validator);
        }
    }

    public function _initForm(\$vo = null)
    {
        \$profiles = \App\Models\Profile::where('id', '>',  auth()->user()->profile_id)->lists('name','id');
        return array('vo' => \$vo, 'profiles' => \$profiles);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array \$data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function _validate(\$vo)
    {
        return Validator::make(Request::all(), [
            'name'      => 'required|max:255',
            'profile_id' => 'required',
        ], [
            'name.required'         => 'O campo Nome é obrigatório.',
            'profile_id.required'     => 'O campo perfil é obrigatório.'
        ]);
    }


    public function _postSave(\$vo) {
        // Salvar a imagem do usuario
        \$image = Request::file('image');

        \$uploadSuccess = false;
        if (!is_null(\$image)) {

            \$destinationPath = public_path() . '/uploads/users/'.md5(\$vo->id);
                //            \$filename = \$brandImage->getClientOriginalName();
            \$fileExtension = \$image->getClientOriginalExtension();

                // Save the gallery object
            \$fileName = uniqid().'.'.\$fileExtension;
            ;
            \$vo->image = \$fileName;
                // Save the upload file
            \$uploadSuccess = \$image->move(\$destinationPath, \$fileName);
        }

        if (\$uploadSuccess) {
            // resizing an uploaded file
            Image::make(\$destinationPath . '/' . \$fileName)->resize(100, 100)
                ->save(\$destinationPath . '/' . "100x100_" . \$fileName);
        }
        \$vo->save();
    }

    public function remove(\$id) {

        \$vo = \$this->repository->find(\$id);
        if ((\$vo->profile_id <= auth()->user()->profile_id) && \$vo->id != auth()->user()->id) {
            \Session::flash('warnings', array('Você não tem permissão'));
            return redirect('/users');
        }

       parent::remove(\$id);
    }



    public function autocompleteConsultant(\$term = '') {
        return DB::table('users')
            ->select(DB::raw('id, name as name'))
            ->where('name', 'like', '%'. \$term . '%')
            ->whereNull('deleted_at')
            ->get();
    }



}
EOF;

        $this->saveFiles();

        $this->comment("All complete");

        return $this->info('Forms created');

    }


    /**
     * Salva todas as models carregadas
     */
    private function saveFiles()
    {
        $fileName = __DIR__ . '/../../Http/Controllers/Auth';
        if (!is_dir($fileName)) {
            mkdir($fileName);
        }

        $fileName .= '/UserController.php';

        file_put_contents($fileName, $this->userControllerContent);
        $this->comment('Created UserController in '.$fileName);


        $fileName = __DIR__ . '/../../../resources/views/auth/users';

        if (!is_dir($fileName)) {
            mkdir($fileName);
        }

        $fileName .= '/form.blade.php';

        file_put_contents($fileName, $this->formContent);
        $this->comment('Created form.blade.php in '.$fileName);


        $fileName = __DIR__ . '/../../../resources/views/auth/users';
        if (!is_dir($fileName)) {
            mkdir($fileName);
        }

        $fileName .= '/index.blade.php';

        file_put_contents($fileName, $this->indexContent);
        $this->comment('Created index.blade.php in '.$fileName);
    }


}
