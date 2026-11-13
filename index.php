<?php

require __DIR__ . '/includes/app.php';

use \App\Http\Router;

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
include __DIR__ . '/routes/pages.php';


$obRouter->run()->sendResposne();


