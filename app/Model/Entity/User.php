<?php


namespace App\Model\Entity;
use PDOStatement;
use WilliamCosta\DatabaseManager\Database;



class User
{

    /**
     * ID DO USUARIO
     * @var string
     */
    public $id;

    /**
     * NOME DO USUÁRIO
     * @var string
     */
    public $nome;


    /**
     * EMAIL DO USUÁRIO
     * @var string
     */
    public $email;

    /**
     * SENHA DO USUÁRIO
     * @var string 
     */
    public $senha;


    
    /**
     * Método responsavel por cadastrar a instancia atual do banco de dados of cadastrar
     * @return boolean
     */
    public function cadastrar()
    {
       
        //INSERE O USUÁRIO NO BANCO DE DADOS
        $this->id = (new Database('usuarios'))->insert([
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha
        ]);


        return true;
    }


     /**
     * METODO RESPONSAVEL POR ATUALIZAR A ESTANCIA NO BANCO DE DADOS
     * @return boolean
     */
    public function atualizar()
    {

        //ATUALIZA O USUÁRIO NO BANCO DE DADOS
        return (new Database('usuarios'))->update('id = '.$this->id,[
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha
        ]);

    }

    
     /**
     * Método responsavel por excluir o depoimento do banco de dados
     * @return boolean
     */
    public function excluir()
    {

        //EXCLUIR O USUÁRIO NO BANCO DE DADOS
        return (new Database('usuarios'))->delete('id = '.$this->id);

    }



    /**
     * MÉTODO RESPONSAVEL POR RETORNAR OS USUÁRIOS
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('usuarios'))->select($where, $order, $limit, $fields);
    }


    /**
     * MÉTODO RESPONSAVEL POR RETORNAR OS USUÁRIOS POR ID
     * @param integer $id
     * @return User
     */
    public static function getUserById($id)
    {
        return self::getUsers('id = ' . $id)->fetchObject(self::class);
    }



    /**
     * MÉTODO RESPONSAVEL POR RETORNAR UM USUÁRIO COM BASE NO SEU E-MAIL
     * @param string $email
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return (new Database('usuarios'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }


}