<?php


namespace App\Controller\Admin;

use App\Utils\View;

class Alert
{

    /**
     * MÉTODO REPSONSÁVEL POR RETORNAR UMA MESAGEM DE ERRO
     * @param string $message
     * @return string
     */
    public static function getError($message)
    {
        return View::render('admin/alert/status', [
            'tipo' => 'danger',
            'mensagem' => $message
        ]);
    }

    /**
     * MÉTODO REPSONSÁVEL POR RETORNAR UMA MESAGEM DE ERRO
     * @param string $message
     * @return string
     */
    public static function getSuccess($message)
    {
        return View::render('admin/alert/status', [
            'tipo' => 'success',
            'mensagem' => $message
        ]);
    }
 

}