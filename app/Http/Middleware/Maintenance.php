<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;
use Closure;

class Maintenance
{


    /**
     * MÉTODO RESPONSÁVEL POR EXECUTAR O MIDDLEWARES
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        //VERIFICA O ESTADO DE MANUTENÇÃO DA PÁGINA
        if (getenv('MAINTENANCE') == 'true') {
            throw new \Exception("Página em Manutenção. Tente novamente mais tarde", 200);

        }
        return $next($request);
    }
}