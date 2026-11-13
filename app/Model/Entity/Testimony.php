<?php


namespace App\Model\Entity;

use PDOStatement;
use WilliamCosta\DatabaseManager\Database;


class Testimony
{

    /**
     * Id do depoimento
     * @var integer
     */
    public $id;


    /**
     * Nome do usuário que fez o depoimento
     * @var string
     */


    public $nome;


    /**
     * conteudo da mensagem 
     * @var string
     */
    public $mensagem;


    /**
     * data da publicação do depoimento
     * @var string
     */
    public $data;


    /**
     * Método responsavel por cadastrar a instancia atual do banco de dados of cadastrar
     * @return boolean
     */
    public function cadastrar()
    {
        //DEFINE A DATA DO DEPOIMENTO
        $this->data = date('Y-m-d H:i:s');


        //INSERE O DEPOIMENTO NO BANCO DE DADOS
        $this->id = (new Database('depoimentos'))->insert([
            'nome' => $this->nome,
            'mensagem' => $this->mensagem,
            'data' => $this->data,
        ]);


        return true;
    }

    /**
     * MÉTODO RESPONSAVEL POR RETORNAR OS DEPOIMENTOS
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('depoimentos'))->select($where,$order,$limit,$fields);
    }


}