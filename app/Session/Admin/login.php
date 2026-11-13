<?php

namespace App\Session\Admin;

use App\Model\Entity\User;

class Login
{

    /**
     * MÉTODO REPSONSAVEL POR INICIAR A SESSÃO
     * @param [type] $obUser
     * @return void
     */
    private static function init()
    {

        //VERIFICA SE A SESSÃO ESTÁ ATIVA
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }


    /**
     * MÉTODO RESPONSÁVEL POR CRIAR O LOGIN DO USUÁRIO
     * @param User $obUser
     * @return boolean
     */
    public static function login($obUser)
    {

        global $_SESSION;

        //INICIA A SESSÃO
        self::init();

        //DEFINE A SESSAO DO USUARIO
        $_SESSION['admin']['usuario'] = [
            'id' => $obUser->id,
            'nome' => $obUser->nome,
            'email' => $obUser->email

        ];

        return true;

    }


    //VERIFICA SE O USUARIO ESTA LOGADO
    public static function isLogged()
    {
        //INICIA A SESSÃO
        self::init();

        //RETORNA A VERIFICAÇÃO DO USUARIO E SE TEM ID


        return isset($_SESSION['admin']['usuario']['id']);

    }

    /**
     * METODO RESPONSÁVEL POR EXECUTAR O LOGOUT DO USUARIO
     * @return boolean
     */

    public static function logout()
    {
        //INICIA A SESSÃO
        self::init();

        //DESLOGA O UNISÁRIO
        unset($_SESSION['admin']['usuario']);


        return true;

    }




}
