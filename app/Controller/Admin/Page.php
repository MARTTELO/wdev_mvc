<?php


namespace App\Controller\Admin;

use App\Http\Request;
use App\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;


class Page
{


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
            $links .= View::render('admin/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' =>$page['current'] ? 'active' : ''
            ]);
        }

        //RENDERIZA A BOX DE PAGINAÇÃO
        return View::render('admin/pagination/box', [
            'links' => $links

        ]);
    }


    /**
     * MÓDULOS DISPONÍVEIS NO PAINEL
     * @var array
     */
    private static $modules = [
        'home' => [
            'label' => 'Home',
            'link' => URL . '/admin'
        ],
        'testimonies' => [
            'label' => 'Depoimentos',
            'link' => URL . '/admin/testimonies'
        ],

        'users' => [
            'label' => 'Usuários',
            'link' => URL . '/admin/users'
        ],
    ];


    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR O CONTEÚDO (VIEW) DA ESTRUTURA GENÉRICA DA
     * PAGINA DO PAINEL
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('admin/page', [
            'title' => $title,
            'content' => $content
        ]);

    }


    /**
     * MÉTODO RESPONSÁVEL POR RENDERIZAR A VIEW DO MENU DO PAINEL
     * @param string $currentModule
     * @return string
     */
    private static function getMenu($currentModule)
    {

        //LINKS DO MENU
        $links = '';

        //ITERA OS MÓDULOS
        foreach (self::$modules as $hash=>$module) {
            $links .= View::render('admin/menu/link', [
                'label' => $module['label'],
                'link' => $module['link'],
                'current' => $hash == $currentModule ? 'text-danger' : ''
            ]);
        }


        // RETORNA A RENDERIZAÇÃO DO MENU
        return View::render('admin/menu/box', [
            'links' => $links
        ]);

    }


    /**
     * MÉTODO RESPONSÁVEL POR RENDERIZAR A VIEW DO PAINEL CON CONTÚDOS DIMÂMICOS
     * PAGINA DO PAINEL
     * @param string $title
     * @param string $content
     * @param string $currentModule
     * @return string
     */
    public static function getPanel($title, $content, $currentModule)
    {

        //RENDERIZA A VIEW DO PAINEL
        $contentPanel = View::render('admin/panel', [
            'menu' => self::getMenu($currentModule),
            'content' => $content
        ]);

        //RETORNA A PÁGINA RENDERIZADA
        return self::getPage($title, $contentPanel);
    }


}