<?php
use Slim\Http\Request;
use Slim\Http\Response;


//use App\Controller\UserController;

//DBConnect::Connfun();
//HomeController::go();
//$dat = new HomeController("do");
//echo $dat->getdb();
//header('Access-Control-Allow-Origin: *');

$app = new \Slim\App($container);

$container = $app->getContainer();

//Enable debugging (on by default)
$app->config('debug', true);

$app-> get('/', function($request, $response, $args){
    
    return "hello";
});


$app->group('/auth', function () {
    $this-> get('/', function(){ return "Hello"; });
    $this-> post('/login',  \UserController::class . ':login');
    $this-> post('/register',  \UserController::class . ':register');
    $this-> post('/logout',  \UserController::class . ':logout');
    $this-> post('/update',  \UserController::class . ':update');
    $this-> post('/profile',  \UserController::class . ':profile');
});

$app->group('/buzz', function () {
    $this-> get('/', function(){ return "Hello"; });
    $this-> get('/view',  \BuzzController::class . ':view');
    $this-> get('/follow/{id}',  \BuzzController::class . ':follow');
});


//run App
$app->run();
