<?php


use \App\Http\Response;
use \App\Controller\Admin;

//ROTA ADMIN
$obRouter->get('/admin/testimonies', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::getTestimonies($request));
    }
]);

//ROTA NOVO DEPOIMENTO
$obRouter->get('/admin/testimonies/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::getNewTestimony($request));
    }
]);

//ROTA NOVO DEPOIMENTO {post}
$obRouter->post('/admin/testimonies/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::setNewTestimony($request));
    }
]);


//ROTA EDIÇÃO DO DEPOIMENTO
$obRouter->get('/admin/testimonies/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request,$id) {
        return new Response(200, Admin\Testimony::getEditTestimony($request,$id));
    }
]);


//ROTA EDIÇÃO DO DEPOIMENTO{post}
$obRouter->post('/admin/testimonies/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request,$id) {
        return new Response(200, Admin\Testimony::setEditTestimony($request,$id));
    }
]);

//ROTA DE EXCLUSAO DO DEPOIMENTO{delete}
$obRouter->get('/admin/testimonies/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request,$id) {
        return new Response(200, Admin\Testimony::getDeleteTestimony($request,$id));
    }
]);


//ROTA EDIÇÃO DO DEPOIMENTO{post}
$obRouter->post('/admin/testimonies/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request,$id) {
          return new Response(200, Admin\Testimony::setDeleteTestimony($request,$id));
    }
]);