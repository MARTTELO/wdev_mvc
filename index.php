<?php

require_once 'vendor/autoload.php';

use \App\Http\Router;
use App\Utils\View;

define('URL', 'https://localhost/wdev_mvc');

//DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init([
    'URL' => URL,
]);



// TESTE REQUEST
// $objRequest = new \App\Http\Request;
// echo '<pre>';
// print_r($objRequest);
// echo '</pre>';
// // exit;


// TESTE RESPONSE 
// $objReponse = new \App\Http\Response(200,'Olá Mundo');
// $objReponse->sendResposne();
// echo '<pre>';
// print_r($objReponse);
// echo '</pre>';
// exit;


//TESTANDO A ROTA
// $obRouter = new Router(URL);
// echo '<pre>';
// print_r($obRouter);
// echo '</pre>';
// exit;

$obRouter = new Router(URL);

//INCLUINDO AS ROTAS DE PÁGINA
include __DIR__.'/routes/pages.php';


$obRouter->run()->sendResposne();
