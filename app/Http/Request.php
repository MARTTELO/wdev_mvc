<?php

namespace App\Http;

class Request
{
    /**
     * INSTÂNCIA DO ROUTER
     * @var Router
     */
    private $router;


    /**
     * MÉTODO HTTP DA REQUISIÇÃO
     * @var string
     */
    private $httpMethod;

    /**
     * URI DA PÁGINA
     * @var string
     */
    private $uri;

    /**
     * PARÂMENTROS DA URL ($_GET)
     * @var array
     */
    private $queryParams = [];


    /**
     * VARIÁVEIS RECEBIDAS NO POST DA PÁGINA ($_POST)
     * @var array
     */
    private $postVars = [];

    /**
     * CABEÇALHO DA REQUISIÇÃO
     * @var array
     */
    private $headers = [];

    /**
     * MÉTODO CONSTRUTOR DA REQUISIÇÃO
     * @param Router
     */
    public function __construct($router)
    {
        $this->router = $router;
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->setUri();

    }

    /**
     * MÉTODO RESPONSÁVEL POR DEFINIR A URI
     * @return void
     */
    private function setUri()
    {

        //URI COMPLETA (COM GETS)
        $this->uri = $_SERVER['REQUEST_URI'];

        //REMOVENDO GETS DA URI
        $xUri = explode('?', $this->uri);
        $this->uri = $xUri[0];
       
    }




    /**
     * METODO RESPONSAVEL POR RETORNAR A INSTÂNCIA DE ROUTER
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }


    /**
     * MÉTODO RESPONSAVEL POR RETORNAR O MÉTODO HTTP DA REQUISIÇÃO
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * MÉTODO RESPONSAVEL POR RETORNAR A URI DA REQUISIÇÃO
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * MÉTODO RESPONSÁAVEL POR RETORNAR OS HEADERS DA REQUISIÇÃO
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * MÉTODO QUE RETORNA OS PARÂMENTROS DA REQUISIÇÃO
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR AS VARIAÁVEIS DO $_POST DA REQUISIÇÃO
     * @return array
     */
    public function getPostVars()
    {
        return $this->postVars;
    }

}