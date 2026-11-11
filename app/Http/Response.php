<?php

namespace App\Http;


class Response
{

    /**
     * CÓDIGO DO STATUS HTPP
     * @var int
     */
    private $httpCode = 200;

    /**
     * CABEÇALHO DO RESPONSE
     * @var array 
     */
    private $headers = [];

    /**
     * DEFINE O TIPO DE CONTEÚDO RETORNADO PARA O USUÁRIO
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * CONTEÚDO DO RESPONSE
     * @var mixed 
     */
    private $content;

    /**
     * MÉTODO REPONSÁVEL POR INICIAR A CLASSE E DEFINIR OS VALORES
     * @param integer $httpCode
     * @param mixed $content
     * @param string $contentType
     * @throws \Exception
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {

        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * MÉTODO RESPONSÁVEL POR ALTERAR O CONTENT TYPE DO RESPONSE
     * @param string $contentType
     * @return void
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type:', $contentType);
    }

    /**
     * MÉTODOS RESPONSÁVEL POR ADICIONAR UM REGISTRO NO CABEÇALHO DO RESPONSE
     * @param mixed $keys
     * @param mixed $values
     * @return void
     */
    public function addHeader($keys, $values)
    {
        $this->headers[$keys] = $values;
    }


    /**
     * MÉTODO RESPONSÁVEL POR ENVIAR OS HEADERS PARA O NAVEGADOR
     * @return void
     */
    private function sendHeaders()
    {
        //STATUS
        http_response_code($this->httpCode);

        //ENVIAR HEADERS
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /**
     * MÉTODO RESPONSÁVEL POR ENVIAR A REPONSTA PARA O USUÁRIO
     * @return void
     */
    public function sendResposne()
    {

        //ENVIA OS HEADERS
        $this->sendHeaders();


        //IMPRIME O CONTEÙDO
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                break;

            default:
                # CODE...
                break;
        }

    }

}