<?php

namespace App\Controller\Pages;
use \App\Utils\View;

class Page
{

    /**
     * METODO RESPONSAVEL POR RENDERIZAR O TOPO DA PÁGINA
     * @return string
     */
    public static function getHeader()
    {
        return View::render('pages/header');
    }


    /**
     * METODO RESPONSAVEL POR RENDERIZAR O RODAPE DA PÁGINA
     * @return string
     */
    public static function getFooter()
    {
        return View::render('pages/footer');
    }





    /**
     * METODO RESPOSAVEL POR RETORNAR A VIEW DA HOME
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('pages/page', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()
            
        ]);
    }
}