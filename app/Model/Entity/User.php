<?php


namespace App\Model\Entity;


use \WilliamCosta\DatabaseManager\Database;



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
     * MÉTODO RESPONSAVEL POR RETORNAR UM USUÁRIO COM BASE NO SEU E-MAIL
     * @param string $email
     * @return User
     */
    public static function getUserByRmail($email)
    {
        return (new Database('usuarios'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }


}