<?php

use App\Controller\Pages\Home;
use App\Http\Response;
use App\Controller\Pages;




// ROTA HOME
$obRouter->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    
    }
   
]);

//ROTA SOBRE
$obRouter->get('/sobre', [
    function () {
        return new Response(200, Pages\About::getAbout());

    }
]);

//ROTA DEPOIMENTOS
$obRouter->get('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Testimony::getTestimonies($request));

    }
]);
$obRouter->post('/depoimentos', [
    function ($request) {
        // echo '<pre>';
        // print_r($request);
        // echo '</pre>';
        return new Response(200, Pages\Testimony::insertTestimony($request));

    }
]);


//ROTA DINÂMICA
// $obRouter->get('/pagina/{idPagina}/{acao}', [
//     function ($idPagina, $acao) {
//         return new Response(200, 'Pagina ' . $idPagina . '-' . $acao);

//     }
// ]);