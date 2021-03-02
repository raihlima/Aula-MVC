Depois de clonar o repositório usar o comando no terminal dentro da pasta: 
```
composer install
``` 
Configurar o arquivo .env conforme o banco de dados.
```
php artisan migrate --seed
```

```
php artisan serve
```

# Aula MVC
## Ferramentas Utilizadas
- PHP
- Composer – Gerenciador de pacotes php
- Bootstrap – Framework
- Laravel – FrameWork
- MySQL
- MySQL Workbench
- Visual Studio
- NPM - Gerenciador de pacotes js.

## 1- Criação da aplicação web
Crie uma pasta para guarda a aplicação, em seguida, abra a pasta e execute o terminal.
Digite o seguinte comando:
```
composer create-project laravel/laravel AulaMVC-app
```
Para instalar o composer na aplicação
```
composer require laravel/ui
```

Para abrir a aplicação execute o comando:
```
php artisan serve
```

## 1.1 – Criação do banco de dados

Abra o terminar e digite o seguinte comando:
```
mysql -u root -p
```
Depois o comando:
```
CREATE DATABASE mvc
```

Abrir o arquivo .env na pasta da aplicação e editar:
- APP_NAME: para alterar o nome da aplicaão web
- DB_DATABASE: o nome escolhido da database criado no banco
- DB_USERNAME: o usuario do banco de dados
- DB_PASSWORD: a senha do usuário do banco de dados

> APP_NAME=”Campeonatos Tabajara”
> 
> DB_CONNECTION=mysql
> DB_HOST=127.0.0.1
> DB_PORT=3306
> DB_DATABASE=mvc
> DB_USERNAME=root
> DB_PASSWORD=Admin_123


# 1.2 - Criação da autenticação de usuários
Para criar o login e a criação de contas executar os seguintes comandos:
```
php artisan ui vue --auth
npm install && npm run dev
```
Executar o comando abaixo para migrar os dados da aplicação para o banco de dados
```
php artisan migrate
```

Caso não funcione o CSS, execute os comandos, digitando Yes para tudo:
```
php artisan ui vue --auth
npm install && npm run dev
```

## 1.3 Visualização do site
Digite o seguinte comando para ver o site:
```
php artisan serve
```

##### Alteração dos nomes em inglês
Para alterar os nomes em inglês, localize a view welcome.blade.php em resources/views, os nomes que devem ser alterados é o que estão em chaves duplas como o exemplo abaixo: 
`{{ __('Password') }}` altera o nome do password.

## 2 – Passo Configurar o Login para admin e usuario.
Abra o VisualStudio
Abra o arquivo Models/User.php

adicionar `‘admin’` em protected $fillable
```php
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
    ];
```

Depois acrescentar a variavel `$table->boolean('admin')->default(false);` em database/migrations/create_users_table 
```php
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('admin')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
```

Agora para adicionar um administrador, vá em database/seeders/DatabaseSeeder.php e adicione o seguinte código na função run():

importar no seerders use App\Models\User;
```php
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'admin' => true,
            ],
        ];
        User::insert($users);
    }
```
Não esqueça a importação:
```php
use App\Models\User;
```

Agora devemos trocar as tabelas do banco de dados.

Um jeito mais rápido é excluir e criar novamente, já que o banco está vazio.

Para excluir o banco de dados digite o comando sql em SQL Workbench:
```sql
DROP DATABASE mvc;
```
Para criar o banco novamente;
```sql
CREATE DATABASE mvc;
```

Se o site se estiver rodando, parar a aplicação.
Agora vamos migrar os dados da aplicação para o banco de dados com o seeder de admin. Execute o comando no terminal:
```
php artisan migrate --seed
```

Pronto, a aplicação tem um usuário padrão de administrador. Agora vamos separar as páginas de administrador e do jogador( usuário padrão).

## 3 – Configurar Criaçao de Campeonato (Admin)
Execute o comando para criar um modelo de campeonato:
```
php artisan make:model Campeonato --migration
```
Agora abra o modelo do Campeonato em `app/Models`.

Importe:
```php
use DateTimeInterface;
```
Em seguida adicione o código abaixo dentro da classe:
```php
    protected $fillable = [
        'nome',
        'dataLimiteInscricao',
        'dataInicioCampeonato',
        'jogo',
    ];

    protected $dates = [
        'dataLimiteInscricao',
        'dataInicioCampeonato',
        'created_at',
        'updated_at',
    ];

    const GAME_SELECT = [
        'ragnarok' => 'Ragnarok',
        'cs_go' => 'CS:GO',
        'truco' => 'Truco Online',
        'gunbound' => 'Gunbound',
    ];

    protected function serializeDate(DateTimeInterface $date){
        return$date->format('Y-m-d');
}
```

##### Agora vamos criar a tabela de campeonato no banco de dados
Altere o arquivo create campeonatos em database/migrations.

```php
    public function up()
    {
        Schema::create('campeonatos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->timestamp('dataLimiteInscricao');
            $table->timestamp('dataInicioCampeonato');
            $table->string('jogo');
            $table->timestamps();
            });
    }
```

Agora duplique o arquivo home.blade.php em resources/views para ter um home para admin, e sem seguida altere o nome para gerenciamento.blade.php

Coloque um botão para criar campeonatos em gerenciamento.blade.php dentro do `<div class="card-body">`.
```html
<a href="{{route ("gerenciamentoCampeonato.criarCampeonato")}}" class="btn btn-primary">Criar um Campeonato</a>
```

Devemos criar um controlador para gerenciar os campeonatos, para isso, basta digitar o seguinte comando:
```
php artisan make:controller  GerenciamentoCampeonatoController
```

Copiar o método index do homeController em app/Http/Controllers/Auth para o GerenciamentoCampeonatoController, alterando a view para gerenciamento em GerenciamentoCampeonatoController.
```php
return view('gerenciamento');
```
Ainda em GerenciamentoCampeonatoController, vamos bloquear o usuário padrão de entrar na página.
Importe:
```php
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
```

Depois escreva o seguinte código:
```php
    public function index()
    {
        $usuario = Auth::user();
        abort_if(!Auth::user()->admin, Response::HTTP_UNAUTHORIZED, '401 Não autorizado');
        return view('gerenciamento');
    }
```

Agora devemos criar o redirecionamento para a página de criação de campeonato
Vá em routes/web.php para criar uma rota para o administrador.
Importe
```php
use Illuminate\Support\Facades\Auth;
```

Adicione as rotas
```php
Route::get('gerenciamentoCampeonato', [App\Http\Controllers\GerenciamentoCampeonatoController::class, 'index'])->name('gerenciamentoCampeonato');

Route::get('gerenciamentoCampeonato/criarCampeonato', [App\Http\Controllers\GerenciamentoCampeonatoController
::class, 'criarCampeonato'])->name('gerenciamentoCampeonato.criarCampeonato');
```

Devemos também redirecionar o login do home caso seja o administrador.
Vá em app/Http/Controllers/HomeController.php
Importe
```php
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
```

No index altere:
```php
    public function index()
    {
        $usuario = Auth::user();
        if ($usuario->admin) {
            return redirect()->route('gerenciamentoCampeonato');
        } else {
            return view('home');
        }
    }
```

Agora há dois tipos de home, um para o administrador e outro para o jogador(usuário padrão).

#### Criando o formulário para cadastro de campeonatos
Vamos adicionar duas funções, uma para redirecionar a página de criação e outra para gravar no banco de dados um campeonato.
Vá em app/Http/Controllers/GerenciamentoCampeonatoController.php e adicione o seguinte código:
```php
    public function criarCampeonato()
    {
        $usuario = Auth::user();
        abort_if(!Auth::user()->admin, Response::HTTP_UNAUTHORIZED, '401 Não autorizado');
        return view('criarCampeonato');
    }

    public function gravarCampeonato(Request $request)
    {
        $camp = Campeonato::create($request->all());
        return redirect()->route('gerenciamentoCampeonato');
    }
```
Importe no controlador
```php
use App\Models\Campeonato;
```

Clone alguma uma view em resources/views para cadastro de campeonatos e altere o nome para criarCampeonato.blade.php
Dentro da view, digite o código: 
```html
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">{{ __('Criar campeonato') }}</div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{route ("gerenciamentoCampeonato.gravarCampeonato")}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nome do campeonato:</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Campeonato Integalático XV" name='nome' required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Selecione o jogo:</label>
                        <select class="form-control" id="exampleFormControlSelect1" name='jogo' required>
                            @foreach(App\Models\Campeonato::GAME_SELECT as $key=>$label)
                            <option value="{{$key}}">{{$label}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Data limite inscrição:</label>
                        <input type="date" class="form-control datetime-local" id="exampleFormControlInput1" name='dataLimiteInscricao' required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Data início das partidas:</label>
                        <input type="date" class="form-control datetime-local" id="exampleFormControlInput1" name='dataInicioCampeonato' required>
                    </div>
                    <input type="submit" value="Criar campeonato" class="btn btn-primary" />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
```

Agora criar também uma rota para gravação no banco de dados em routes/web.php

```php
Route::post('gerenciamentoCampeonato/gravarCampeonato', [App\Http\Controllers\GerenciamentoCampeonatoController::class, 'gravarCampeonato'])->name('gerenciamentoCampeonato.gravarCampeonato');
```

Agora vamos migrar a tabela de campeonato da aplicação para o banco, digite no terminal:
```
php artisan migrate
```

##### Mostrando os campeonatos criados na página inicial
Altere o controlador de Gerenciamento de campeonatos em app/Http/Controllers/GerenciamentoCampeonatoController.php
```php
    public function index()
    {
        $usuario = Auth::user();
        abort_if(!Auth::user()->admin, Response::HTTP_UNAUTHORIZED, '401 Não autorizado');
        $camps = Campeonato::all();
        return view('gerenciamento', compact('camps'));
    }
```

Agora aterar a view da página de Gerenciamento para listar os campeonatos inscritos:
```html
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">{{ __('Tabela de Campeonatos') }}</div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <table>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Modalidade</th>
                                <th>Data limite inscrição</th>
                                <th>Data início das partidas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($camps as $camp)

                            <tr>
                                <td>{{$camp['nome']}}</td>
                                <td>{{App\Models\Campeonato::GAME_SELECT[$camp['jogo']??'']}}</td>
                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$camp['dataLimiteInscricao'])->format('d/m/Y')}}</td>
                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$camp['dataInicioCampeonato'])->format('d/m/Y')}}</td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>

                    <br><a href="{{route ("gerenciamentoCampeonato.criarCampeonato")}}" class="btn btn-primary">Cadastrar Campeonato</a>

            </div>
        </div>
    </div>
</div>
</div>
@endsection
```

## 4 – Configurar Cadastrar time no Campeonato (Jogador)
Crie um jogador na aplicação caso não tenha nenhum registrado.

Edite a view home em resources/views/ para mostrar os campeonatos:

```html
<div class="card">
    <div class="card-header">{{ __('Campeonatos') }}</div>
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
         @endif
        <table>
            <table class="table">
            <thead>
            <tr>
            <th>Nome</th>
    <th>Modalidade</th>
    <th>Data limite inscrição</th>
    <th>Data início das partidas</th>
    <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($camps as $camp)
    
            <tr>
                <td>{{$camp['nome']}}</td>
                <td>{{App\Models\Campeonato::GAME_SELECT[$camp['jogo']??'']}}</td>
                <td>{{$camp['dataLimiteInscricao']}}</td>
                <td>{{$camp['dataInicioCampeonato']}}</td>
                <td><a href="{{route ("inscricaoTime", $camp['id'] )}}" class="btn btn-primary">Inscrever Time</a></td>
            </tr>
    @endforeach
          </tbody>
        </table>
    </div>
</div>
```

Altere HomeController em app/Http/Controllers/HomeController.php
Importe:
```php
use App\Models\Campeonato;
```

Altere a função index:
```php
    public function index()
    {
        $usuario = Auth::user();
        if ($usuario->admin) {
            return redirect()->route('gerenciamentoCampeonato');
        } else {
            $camps = Campeonato::all();
            return view('home', compact('camps', 'usuario'));
        }
    }
```

Criar uma rota para InscricaoTime em routes/web.php:
```php
Route::get('campeonato/inscricaoTime/{id}', [App\Http\Controllers\InscricaoCampeonatoController::class, 'create'])->name('inscricaoTime');
```

Altere a variável `$camps` no homeController em app/Http/Controllers/HomeController.php para listar os campeonatos que já passaram da data limite de inscrição:
```php
$camps = Campeonato::where('dataLimiteInscricao','>=',date('Y-m-d'))->get();
```
Agora vamos criar um modelo para inscrição no campeonato
Escreva no terminal:  
```
php artisan make:model InscricaoCampeonato --migration
```

Altere a migration de inscrever time no campeonato localizada em database/migrations
```php
    public function up()
    {
        Schema::create('inscricao_campeonatos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idJogador');
            $table->foreign('idJogador')->references('id')->on('users');
            $table->unsignedBigInteger('idCampeonato');
            $table->foreign('idCampeonato')->references('id')->on('campeonatos');
            $table->text('nomeTime');
            $table->text('nomeJogadores');
            $table->timestamps();
            });
    }
```

Altere o modelo Inscricao Campeonato em app/Models/InscricaoCampeonato.php:
```php
    protected $fillable = [
        'id',
        'idJogador',
        'idCampeonato',
        'nomeTime',
        'nomeJogadores',
    ];
```

Feito isso, use o comando para criar a tabela no banco de dados: 
```
php artisan migrate
```

Agora, altere o Home controller, localizado em app/Http/Controllers/HomeController.php:
Importe
```php
use App\Models\InscricaoCampeonato;
```
Altera o index para:
```php
    public function index()
    {
        $usuario = Auth::user();
        if ($usuario->admin) {
            return redirect()->route('gerenciamentoCampeonato');
        } else {
            $inscrito = InscricaoCampeonato::where('idJogador','=',$usuario->id)->get('idCampeonato')->toArray();
            $camps = Campeonato::where('dataLimiteInscricao','>=',date('Y-m-d'))->whereNotIn('id',$inscrito)->get();
            return view('home', compact('camps', 'usuario'));
        }
    }
```

Alterar a view home, localizada em resources/views/home.blade.php:
```html
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Campeonatos Inscritos') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Modalidade</th>
                                    <th>Data limite inscrição</th>
                                    <th>Data início das partidas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usuario->inscricoes as $inscricao)

                                <tr>
                                    <td>{{$inscricao->retornaCampeonato()['nome']}}</td>
                                    <td>{{App\Models\Campeonato::GAME_SELECT[$inscricao->retornaCampeonato()['jogo']??'']}}</td>
                                    <td>{{$inscricao->retornaCampeonato()['dataLimiteInscricao']}}</td>
                                    <td>{{$inscricao->retornaCampeonato()['dataInicioCampeonato']}}</td>

                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">{{ __('Campeonatos') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Modalidade</th>
                                    <th>Data limite inscrição</th>
                                    <th>Data início das partidas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($camps as $camp)

                                <tr>
                                    <td>{{$camp['nome']}}</td>
                                    <td>{{App\Models\Campeonato::GAME_SELECT[$camp['jogo']??'']}}</td>
                                    <td>{{$camp['dataLimiteInscricao']}}</td>
                                    <td>{{$camp['dataInicioCampeonato']}}</td>
                                    <td><a href="{{route ("inscricaoTime", $camp['id'] )}}" class="btn btn-primary">Inscrever Time</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

Acrecente no model User, localizado em app/Models/User.php.
```php
public function inscricoes(){
    return $this->hasMany(InscricaoCampeonato::class,'idJogador','id');
}
```

Deve-se criar um controlador para Inscrição no Campeonato, para isso, abra o terminal e digite:
```
php artisan make:controller InscricaoCampeonatoController --model=InscricaoCampeonato
```

Feito isso altere o InscricaoCampeonatoController em app/Http/Controllers/InscricaoCampeonatoController.php
Importações:
```php
use App\Models\InscricaoCampeonato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Campeonato;
```

Funções:
```php
    public function create($id)
    {
        $campeonato = Campeonato::where('id', '=', $id)->first();
        return view('inscricaoTime', compact('campeonato'));
    }
    
    public function store(Request $request)
    {
        $camp = InscricaoCampeonato::create(
            [
                'idJogador' => auth::user()->id,
                'idCampeonato' => $request->campeonatoID,
                'nomeTime' => $request->nomeTime,
                'nomeJogadores' => $request->nomeJogadores,
            ]
        );
        return redirect()->route('home');
    }
```
Agora devemos criar uma view para inscricao campeonato:
Copie alguma view em resources/views e altere o nome para inscricaoTime.blade.php
Depois, altere os campos para:
```html
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Inscrever Time') }} - {{ $campeonato['nome']}}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="POST" action="{{route ("inscricao.store")}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Nome do time:</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Realgoritmos" name='nomeTime' required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Jogadores:</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name='nomeJogadores' required></textarea>
                        </div>
                        <input type="hidden" name="campeonatoID" value="{{ $campeonato['id'] }}">
                        <input type="submit" value="Inscrever Time" class="btn btn-primary" />
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

Devemos também criar uma rota, vá em web, localizado em routes/web.php e adicione a rota:
```php
Route::post('campeonato/inscricaoTime/gravar', [App\Http\Controllers\InscricaoCampeonatoController::class, 'store'])->name('inscricao.store');
```
Finalizando, vá em models InscricaoCampeonato,caminho app/Models/InscricaoCampeonato.php, adicione a função na classe:
```php
public function retornaCampeonato(){
    return Campeonato::find($this->idCampeonato);
}
```

