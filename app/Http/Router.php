<?php

namespace App\Http;

use \Closure;
use Exception;
use \App\Http\Request;
use ReflectionFunction;

class Router
{

    /**
     * URL completa do projeto(raiz)
     * @var string
     */
    private $url = '';


    /**
     * Prefixo de todas as rotas
     * @var string
     */
    private $prefix = '';


    /**
     * Índice de rotas
     * @var array
     */
    private $routes = [];



    /**
     * Instância de Request
     * @var Request
     */
    private $request;


    /**
     * Método responsável por iniciar a classe
     * @param string $url
     */

    public function __construct($url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();

    }

    /**
     * Método responsável por definir o prefixo das rotas
     * @return void
     */
    private function setPrefix(): void
    {
        //INFORMAÇÕES DA URL ATUAL
        $parseUrl = parse_url($this->url);

        // DEFINE O PREFIXO
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Método responsável por adicionar uma rota na classe
     * @param string $method
     * @param string $route
     * @param array $params
     */
    private function addRoute($method, $route, $params = [])
    {
        //REMOVE O ESPAÇO EM BRANCO DA ROTA CASO TENHA SIDO DIGITADO POR ENGANO
        $route = trim($route);

        //VALIDAÇÃO DOS PARAMENTROS
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);

            }

        }

        //VARIÁVEIS DA ROTA
        $params['variables'] = [];

        //PADRAO DE VALIDAÇÂO DAS VARIAVEIS DAS ROTAS]
        $patternVariable = '/{(.*?)}/';

        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        //PADRÃO DE VALIDAÇÃO DA URL
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
        // echo '<pre>';
        // print_r($patternRoute);
        // echo '</pre>';

        //ADICIONA A ROTA DENTRO DA CLASSE
        $this->routes[$patternRoute][$method] = $params;
    }


    /**
     * Método responsável por definir uma rota de GET
     * @param string $route
     * @param array $params
     * @return void
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);

    }
    /**
     * Método responsável por definir uma rota de POST
     * @param string $route
     * @param array $params
     * @return void
     */
    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);

    }
    /**
     * Método responsável por definir uma rota de PUT
     * @param string $route
     * @param array $params
     * @return void
     */
    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);

    }
    /**
     * Método responsável por definir uma rota de DELETE
     * @param string $route
     * @param array $params
     * @return void
     */
    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);

    }


    /**
     * Método reponsável por retonar uma URI desconsiderando o prefixo
     * @return string
     */
    private function getUri()
    {
        //URI DA REQUEST  
        $uri = $this->request->getUri();

        //RETIRA O PREFIXO DA URI
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        // retorna a Uri sem  o prefixo
        return end($xUri);
    }

    /**
     * Método responsável por retornar os dados da rota atual
     * @return array
     */
    private function getRoute()
    {
        //URI
        $uri = $this->getUri();

        //METHOD DA REQUISIÇÃO
        $httpMethod = $this->request->getHttpMethod();

        //VALIDA AS ROTAS
        foreach ($this->routes as $patternRoute => $methods) {
            //VERIFICA SE A URI BATE COM O PADRÃO
            if (preg_match($patternRoute, $uri, $matches)) {
                //VERIFICA O MÉTODO
                if (isset($methods[$httpMethod])) {
                    //REMOVENDO A PRIMEIRA POSIÇÃO
                    unset($matches[0]);

                    // COMBINANDO AS CHAVES DAS $METHODS COM $MATCHES
                    // VARIAVEIS PROCESSADAS
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    //RETORNO DOS PARÂMETROS DA TROTA
                    return $methods[$httpMethod];

                }
                //MÉTODO NÃO PERMITIDO / DEFINIDO
                throw new Exception("Método não permitido", 405);
            }
        }

        //URL NÃO ENCONTRADA
        throw new Exception("URL não encontrada", 404);

    }



    /**
     * Método responsável por executar a rota atual
     * @return Response|null
     */
    public function run()
    {
        try {
            //OBTEM A ROTA ATUAL
            $route = $this->getRoute();

            //VERIFICA O CONTROLADOR
            if (!isset($route['controller'])) {
                throw new Exception("URL não pode ser processada", 500);

            }

            //ARGUMENTOS DA FUNÇÃO
            $args = [];

            //REFLECTION
            $reflection = new ReflectionFunction($route['controller']);
            foreach($reflection->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';

            }

            //CLASSE QUE FAZ UM ESPELHO DA FUNÇÃO 

            //RETORNA A EXECUÇÃO DA RUN
            return call_user_func_array($route['controller'], $args);

        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }

    }
}






