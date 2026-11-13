<?php

use \App\Http\Response;
use \App\Controller\Admin;

//ROTA ADMIN
$obRouter->get('/admin', [
     'middlewares' => [
        'required-admin-login'
    ],
    function () {
        return new Response(200, 'Admin :)');
    }
]);

//ROTA ADMIN
$obRouter->get('/admin/login', [
    'middlewares' => [
        'required-admin-logout'
    ],
    function ($request) {
        return new Response(200, Admin\Login::getLogin($request));
    }
]);

//ROTA ADMIN
$obRouter->post('/admin/login', [
     'middlewares' => [
        'required-admin-logout'
    ],
    function ($request) {
        // echo password_hash('123456', PASSWORD_DEFAULT);
        // echo '<pre>';
        // print_r($request->getPostVars());
        // echo '</pre>';
        return new Response(200, Admin\Login::setLogin($request));
    }

]);

//ROTA DE LOGOUT
$obRouter->get('/admin/logout', [
     'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Login::setLogout($request));
    }
]);
