<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Http\Response;
use Closure;

class Queue
{

    /**
     * MAPEAMENTO DAS MIDDLEWARES
     *
     * @var array
     */
    private static $map = [];
    /**
     * MAPEAMENTO DE MIDDLEWARES QUE SERÃO CARREGADOS EM TODAS AS ROTAS
     * @var array
     */
    private static $default = [];

    /**
     * FILA DE MIDDLEWARES A SEREM EXECUTADOS
     * @var array
     */
    private $middlewares = [];

    /**
     * FUNÇÃO DE EXECUÇÃO DO CONTROLADOR
     * @var Closure
     */
    private $controller;

    /**
     * ARGUMENTOS DA FUNÇÃO DO CONTROLADOR
     * @var array
     */
    private $controllerArgs = [];

    /**
     * MÉTODO RESPONSÁVEÇ POR CONTRUIR A CLASSE DE FILA DE MIDDLEWARES
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs)
    {
        $this->middlewares = array_merge(self::$default, $middlewares);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * MÉTODO RESPONSAVEL POR DEFINIR O MAPEAMENTO DE MIDDLEWARES
     * @param array $map
     * @return void
     */
    public static function setMap($map)
    {
        self::$map = $map;
    }


    /**
     * MÉTODO RESPONSAVEL POR DEFINIR O MAPEAMENTO DE MIDDLEWARES
     * @param array $default
     * @return void
     */
    public static function setDefault($default)
    {
        self::$default = $default;
    }

    /**
     * Executa o próximo NÍVEL DA MIDDLEWARE 
     * @param Request $request
     * @return Response
     */
    public function next($request)
    {
        //VERIFICA SE A FILA ESTÁ VAZIA
        if (empty($this->middlewares))
            return call_user_func_array($this->controller, $this->controllerArgs);


        //MIDDLEWARE
        $middleware = array_shift($this->middlewares);

        //VERIFICA O MAPEAMENTO 
        if (!isset(self::$map[$middleware])) {
            throw new \UnexpectedValueException('Problemas ao processar o middleware da requissição', 500);
        }

        //NEXT
        $middlewareClass = self::$map[$middleware];
        $queue = $this;
        $next = function ($request) use ($queue) {
            return $queue->next($request);
        };

        //EXECUTA O MIDDLEWARE 
        return (new self::$map[$middleware])->handle($request, $next);

    }

}