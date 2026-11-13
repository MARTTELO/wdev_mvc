<?php


namespace App\Controller\Admin;

use App\Utils\View;


class Page
{

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


}