<?php

namespace App\Controller\Pages;
use \App\Utils\View;
use App\Http\Request;
use WilliamCosta\DatabaseManager\Pagination;

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
     * MÉTODO REPOSÁVEL POR RENDERIZAR O LAYOUT DE PAGINAÇÃO 
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    public static function getPagination($request, $obPagination)
    {

        //OBTER AS PAGINAS
        $pages = $obPagination->getPages();

        //VERIFICA A QUANTIDADE DE PAGINAS
        if (count($pages) <= 1)
            return '';

        //LINKS
        $links = '';

        // URL ATUAL DA ROTA SEM O GET
        $url = $request->getRouter()->getCurrentUrl();

        //GET
        $queryParams = $request->getQueryParams();

        //RENDERIZA OS LINK
        foreach ($pages as $page) {
            //ALTERA A PAGINA
            $queryParams['page'] = $page['page'];

            //MONTAR O LINK DA PAGINA
            $link = $url . '?' . http_build_query($queryParams);

            //VIEW
            $links .= View::render('pages/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' =>$page['current'] ? 'active' : ''
            ]);
        }

        //RENDERIZA A BOX DE PAGINAÇÃO
        return View::render('pages/pagination/box', [
            'links' => $links

        ]);
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