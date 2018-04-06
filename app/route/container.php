<?php
use App\Controller\UserController;
use App\Controller\BuzzController;
use App\Database\DB;

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$container = new \Slim\Container($configuration);

$container["db"] = function ($c) { 
    $db = new DB();
    return $db;
};


$container['UserController'] = function ($c) { 
    $db= $c->get("db"); 
    return new UserController($db);
};

$container['BuzzController'] = function ($c) { 
    $db= $c->get("db"); 
    return new BuzzController($db);
};
