<?php

namespace App\Controller\Pages;
use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page
{
    /**
     * metodo resposavel por retornar a view da home
     * @return string
     */
    public static function getHome()
    {

    $objOrganization = new Organization;

        // conteudo View da home
        $content = View::render('pages/Home', [
            'name' => $objOrganization->name,
            'description' => $objOrganization->description,
            'site' => $objOrganization->site
        ]);

        // retorna a view da pagina
        return parent::getPage('Wdev Canal - Home', $content);
    }
}