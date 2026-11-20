<?php



namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Http\Request;
use App\Utils\View;
use App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;
use \App\Controller\Admin\Alert;


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
        $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

        //RESULTADOS DA PÁGINA DE 
        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEMkkkk
        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $itens .= View::render('admin/modules/testimonies/item', [
                'id' => $obTestimony->id,
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/m/Y  -   H:i:s', strtotime($obTestimony->data))
            ]);
        }

        //RETORNO DOS DEPOIMENTOS
        return $itens;
    }




    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR A VIEW DA HOME
     * @param Request $request
     * @return string
     */
    public static function getTestimonies($request)
    {

        //CONTEÚDO DA HOME
        $content = View::render('admin/modules/testimonies/index', [
            'itens' => self::getTestimonyItens($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);

        // RETORNA A PÁGNA COMPLETA
        return parent::getPanel('DEPOIMENTOS -> WDEV', $content, 'testimonies');

    }



    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR O FORMULARIO DE CADASTRO DE UM NOVO DEPOIMENTO
     * @param Request $request
     * @return string
     */
    public static function getNewTestimony($request)
    {

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/form', [
            'title' => 'Cadastrar Depoimento',
            'nome' => '',
            'mensagem' => '',
            'status' => ''

        ]);

        // RETORNA A PÁGNA COMPLETA
        return parent::getPanel('CADASTRAR DEPOIMENTO -> WDEV', $content, 'testimonies');

    }

    /**
     * METODO RESPONSÁVEL POR CADASTRAR UM DEPOIMENTO NO BANCO DE DADOS
     * @param Request $request
     * @return void 
     */

    public static function setNewTestimony($request)
    {

        //DADOS DO POST
        $postVars = $request->getPostVars();

        //NOVA INSTANCIA DE DEPOIMENTO
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();


        //RETORNA A PÁGINA DE DEPOIMENTOS
        // return self::getTestimonies($request);

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies/' . $obTestimony->id . '/edit?status=created');
    }


    /**
     * METODO RESPONSAVEL POR RETORNAR A MENSAGEM DE STATUS
     * @param Request $request
     * @return string
     */
    private static function getStatus($request)
    {

        //QUERY PARAMS
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['status']))
            return '';

        //MENSAGENS

        switch ($queryParams['status']) {
            case 'created':

                return Alert::getSuccess('Depoimento criado com sucesso');

                break;

            case 'updated':

                return Alert::getSuccess('Depoimento atualizado com sucesso');

                break;

            case 'deleted':

                return Alert::getError('Depoimento excluido com sucesso');

                break;
        }


    }


    /**
     * METODO RESPONSÁVEL POR RETORNAR O FOMRULARIO DE EDIÇÃO DO DEPOIMENTO
     * @param Request $request
     * @param integer $id
     * @return string
     */

    public static function getEditTestimony($request, $id)
    {

        //OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/form', [
            'title' => 'Editar depoimento',
            'nome' => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'status' => self::getStatus($request)

        ]);

        // RETORNA A PÁGNA COMPLETA
        return parent::getPanel('Editar Depoimento -> WDEV', $content, 'testimonies');
    }


    /**
     * METODO RESPONSÁVEL POR GRAVAR A ATUALIZAÇÃO DE UM DEPOIMENTO
     * @param Request $request
     * @param integer $id
     * @return void
     */

    public static function setEditTestimony($request, $id)
    {

        //OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //POST VARS
        $postVars = $request->getPostVars();



        // ATUALIZA A INSTANCIA 
        $obTestimony->nome = $postVars['nome'] ?? $obTestimony->nome;
        $obTestimony->mensagem = $postVars['mensagem'] ?? $obTestimony->mensagem;
        $obTestimony->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies/' . $obTestimony->id . '/edit?status=updated');

    }

    /**
     * METODO RESPONSÁVEL POR RETORNAR O FOMULARIO DE EXCLUSAO DO DEPOIMENTO
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteTestimony($request, $id)
    {
        //OBTEM O DEPOIMENTO DO BANCO DE DADOS
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/testimonies/delete', [
            'nome' => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,

        ]);

        // RETORNA A PÁGNA COMPLETA
        return parent::getPanel('Excluir Depoimento -> WDEV', $content, 'testimonies');

    }

    public static function setDeleteTestimony($request, $id)
    {

        //OBTER O DEPOIMENTO
        $obTestimony = EntityTestimony::getTestimonyById($id);

        //VALIDA A INSTANCIS
        if (!$obTestimony instanceof EntityTestimony) {

        }

        //EXCLUI O DEPOIMENTO
        $obTestimony->excluir();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/testimonies?status=deleted');


    }


}