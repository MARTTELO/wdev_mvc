<?php


namespace App\Http\Middleware;


use App\Http\Request;
use App\Http\Response;
use App\Session\Admin\Login as SessionAdminLogin;
use Closure;


class RequireAdminLogout
{


    /**
     * MÉTODO RESPONSÁVEL POR EXECUTAR O MIDDLEWARES
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        //VERIFICA O USUARIO ESTÁ LOGADO
        if (SessionAdminLogin::isLogged()) {

            $request->getRouter()->redirect('/admin');
        }

        return $next($request);
    }

}


