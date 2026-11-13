<?php

namespace App\Controller\Pages;

use \App\Model\Entity\Testimony as EntityTestimony;
use \App\Utils\View;
use \WilliamCosta\DatabaseManager\Pagination;
use App\Http\Request;

class Testimony extends Page
{

    /**
     * MÉTODO REPONSÁVEL POR OBTER OS DEPOIMENTOS DO BANCO DE DADOS PARA A PÁGINA
     * O SEGUNDO PARÂMENTO PERMITE PEGAR OS DADOS MESMO FORA DA PAGINATION
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getTestimonyItens($request, &$obPagination)
    {

        //DEPOIMENTOS
        $itens = '';

        //  QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityTestimony::getTestimonies(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INTANCIA DE PAGINAÇÃO
        $obPagination = New Pagination($quantidadeTotal, $paginaAtual, 3);

        //RESULTADOS DA PÁGINA DE 
        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEMkkkk
        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $itens .= View::render('pages/testimony/item', [
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/m/Y  -   H:i:s', strtotime($obTestimony->data))
            ]);
        }

        //RETORNO DOS DEPOIMENTOS
        return $itens;
    }
    /**
     * METODO RESPOSAVEL POR RETORNAR A VIEW DE DEPOIMENTOS
     * @return string
     * @param Request $request
     */
    public static function getTestimonies($request)
    {

        // CONTEUDO DA VIEW DE DEPOIMENTOS
        $content = View::render('pages/testimonies', [
            'itens' => self::getTestimonyItens($request,$obPagination),
            'pagination' => parent::getPagination($request, $obPagination)

        ]);


        // RETORNA A VIEW DA PAGINA
        return parent::getPage('DEPOIMENTOS > WDEV', $content);
    }


    /**
     * MÉTODO RESPONSÁVEL POR CADASTRAR UM DEPOIMENTO
     * @param Request
     * @return string
     */
    public static function insertTestimony($request)
    {

        //DADOS DO POST
        $postVars = $request->getPostVars();

        //NOVA INSTANCIA DE DEPOIMENTO
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();


        //RETORNA A PÁGINA DE DEPOIMENTOS
        return self::getTestimonies($request);
    }
}