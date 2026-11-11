<?php

namespace App\Controller\Pages;
use \App\Utils\View;
use \App\Model\Entity\Organization;

class About extends Page
{
    /**
     * METODO RESPOSAVEL POR RETORNAR A VIEW ABOUT
     * @return string
     */
    public static function getAbout()
    {

        $objOrganization = new Organization;

        // CONTEUDO VIEW ABOUT
        $content = View::render('pages/about', [
            'about' => $objOrganization->description,
           
        ]);

        // RETORNA A VIEW DA PAGINA
        return parent::getPage('ABOUT', $content);
    }
}