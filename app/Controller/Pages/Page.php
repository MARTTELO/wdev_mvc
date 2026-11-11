<?php

namespace App\Controller\Pages;
use \App\Utils\View;

class Page
{

    /**
     * metodo responsavel por renderizar o topo da página
     * @return string
     */
    public static function getHeader()
    {
        return View::render('pages/header');
    }


    /**
     * metodo responsavel por renderizar o rodape da página
     * @return string
     */
    public static function getFooter()
    {
        return View::render('pages/footer');
    }





    /**
     * metodo resposavel por retornar a view da home
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