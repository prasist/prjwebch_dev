<?php

return [

    /**
     * nome das rotas e o ID da tabela paginas a qual pertence
     */

    'perfil' => '32',
    'clientes' => '1',
    'grupos' =>  '2',
    'permissoes' => '3',
    'paginas' => '4',
    'usuarios' => '5',
    'logs' => '6',
    'igrejas' => '7',
    'status' => '8',
    'idiomas' => '9',
    'graus' => '10',
    'profissoes' => '11',
    'areas' => '12',
    'ministerios' => '13',
    'atividades' => '15',
    'dons' => '16',
    'tipospresenca' => '17',
    'tiposmovimentacao' => '18',
    'grausparentesco' => '19',
    'cargos' => '20',
    'ramos' => '21',
    'civis' => '22',
    'religioes' => '23',
    'habilidades' => '24',
    'disponibilidades' => '25',
    'situacoes' => '26',
    'empresas' => '27',
    'pessoas' => '28',
    'tipospessoas' => '29',
    'grupospessoas' => '31',
    'tipostelefones' => '33',
    'validar' => '5',
    'home' => '34',
    'bancos' => '35',
    'estruturas1' => '36',
    'estruturas2' => '37',
    'estruturas3' => '38',
    'estruturas4' => '39',
    'estruturas5' => '40',
    'configuracoes' => '41',
    'celulas' => '42',
    'publicos' => '43',
    'faixas' => '44',
    'celulaspessoas'=>'45',
    'relcelulas'=>'46',
    'relpessoas'=>'47',
    'contas'=>'48',
    'planos_contas'=>'49',
    'centros_custos'=>'50',
    'grupos_titulos'=>'51',
    'titulos'=>'52',
    'relfinanceiro'=>'53',
    'financeiro'=>'54',
    'tiposrelacionamentos'=>'55',
    'tiposrd'=>'56',
    'questionarios'=>'57',
    'controle_atividades'=>'58',
    'mensagens'=>'59',
    'minhacelula'=>'60',
    'login_membros'=>'61',
    'profile'=>'62',
    'membro_dados'=>'63',
    'configmsg'=>'64',
    'relencontro'=>'65',
    'cursos'=>'66',
    'membersmove'=>'67',
    'relmovimentacoes' => '68',
    'relcursos' => '69',
    'config_gerais' => '70',



    'env' => env('APP_ENV', 'staging'),

    'debug' => env('APP_DEBUG', true),

    'url' => 'http://localhost',

    'timezone' => 'Brazil/East',

    'locale' => 'en',

    'fallback_locale' => 'en',

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    'log' => env('APP_LOG', 'single'),

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        Barryvdh\Debugbar\ServiceProvider::class,
        //Barryvdh\DomPDF\ServiceProvider::class,

        /*
                SNAPPY PDF
        */
        Barryvdh\Snappy\ServiceProvider::class,


        /*Validacao CPF e CNPJ*/
        EltonInacio\ValidadorCpjCnpj\CpfCnpjServiceProvider::class,

        /*Utilizado para Jquery Datatable server-side*/
        Yajra\Datatables\DatatablesServiceProvider::class,

        //Jasper Report
        'JasperPHP\JasperPHPServiceProvider',


        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

        'Intervention\Image\ImageServiceProvider'

    ],


    'aliases' => [

        'App'       => Illuminate\Support\Facades\App::class,
        'Artisan'   => Illuminate\Support\Facades\Artisan::class,
        'Auth'      => Illuminate\Support\Facades\Auth::class,
        'Blade'     => Illuminate\Support\Facades\Blade::class,
        'Cache'     => Illuminate\Support\Facades\Cache::class,
        'Config'    => Illuminate\Support\Facades\Config::class,
        'Cookie'    => Illuminate\Support\Facades\Cookie::class,
        'Crypt'     => Illuminate\Support\Facades\Crypt::class,
        'DB'        => Illuminate\Support\Facades\DB::class,
        'Eloquent'  => Illuminate\Database\Eloquent\Model::class,
        'Event'     => Illuminate\Support\Facades\Event::class,
        'File'      => Illuminate\Support\Facades\File::class,
        'Gate'      => Illuminate\Support\Facades\Gate::class,
        'Hash'      => Illuminate\Support\Facades\Hash::class,
        'Lang'      => Illuminate\Support\Facades\Lang::class,
        'Log'       => Illuminate\Support\Facades\Log::class,
        'Mail'      => Illuminate\Support\Facades\Mail::class,
        'Password'  => Illuminate\Support\Facades\Password::class,
        'Queue'     => Illuminate\Support\Facades\Queue::class,
        'Redirect'  => Illuminate\Support\Facades\Redirect::class,
        'Redis'     => Illuminate\Support\Facades\Redis::class,
        'Request'   => Illuminate\Support\Facades\Request::class,
        'Response'  => Illuminate\Support\Facades\Response::class,
        'Route'     => Illuminate\Support\Facades\Route::class,
        'Schema'    => Illuminate\Support\Facades\Schema::class,
        'Session'   => Illuminate\Support\Facades\Session::class,
        'Storage'   => Illuminate\Support\Facades\Storage::class,
        'URL'       => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View'      => Illuminate\Support\Facades\View::class,
        'Image' => 'Intervention\Image\Facades\Image',
        //'PDF' => Barryvdh\DomPDF\Facade::class,
        'PDF' => Barryvdh\Snappy\Facades\SnappyPdf::class,
        'SnappyImage' => Barryvdh\Snappy\Facades\SnappyImage::class,

    ],

];