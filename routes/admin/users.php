<?php


use \App\Http\Response;
use \App\Controller\Admin;

//ROTA LISTAGEM DO USUARIO
$obRouter->get('/admin/users', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\User::getUsers($request));
    }
]);

//ROTA NOVO USUARIO
$obRouter->get('/admin/users/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\User::getNewUser($request));
    }
]);

//ROTA NOVO USUARIO {post}
$obRouter->post('/admin/users/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\User::setNewUser($request));
    }
]);


//ROTA EDIÇÃO DO USUARIO
$obRouter->get('/admin/users/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request,$id) {
        return new Response(200, Admin\User::getEditUser($request,$id));
    }
]);


//ROTA EDIÇÃO DO USUARIO{post}
$obRouter->post('/admin/users/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request,$id) {
        return new Response(200, Admin\User::setEditUser($request,$id));
    }
]);

//ROTA DE EXCLUSAO DO USUARIO{delete}
$obRouter->get('/admin/users/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request,$id) {
        return new Response(200, Admin\User::getDeleteUser($request,$id));
    }
]);


//ROTA EDIÇÃO DO USUARIO{post}
$obRouter->post('/admin/users/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request,$id) {
          return new Response(200, Admin\User::setDeleteUser($request,$id));
    }
]);