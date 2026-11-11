<?php

namespace App\Controller\Pages;
use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page
{
    /**
     * METODO RESPOSAVEL POR RETORNAR A VIEW DA HOME
     * @return string
     */
    public static function getHome()
    {

        $objOrganization = new Organization;

        // CONTEUDO VIEW DA HOME
        $content = View::render('pages/home', [
            'name' => $objOrganization->name,
            'description' => $objOrganization->description
           
        ]);

        // RETORNA A VIEW DA PAGINA
        return parent::getPage('HOME > WDEV', $content);
    }
}