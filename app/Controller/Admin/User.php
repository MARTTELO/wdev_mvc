<?php



namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Http\Request;
use App\Utils\View;
use App\Model\Entity\User as EntityUser;
use \WilliamCosta\DatabaseManager\Pagination;
use \App\Controller\Admin\Alert;


class User extends Page
{
    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR A VIEW DA HOME
     * @param Request $request
     * @return string
     */
    public static function getUsers($request)
    {

        //CONTEÚDO DA HOME
        $content = View::render('admin/modules/users/index', [
            'itens' => self::getUserItens($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);

        // RETORNA A PÁGNA COMPLETA
        return parent::getPanel('USUÁRIOS -> WDEV', $content, 'users');

    }



    /**
     * MÉTODO RESPONSÁVEL POR RETORNAR O FORMULARIO DE CADASTRO DE UM NOVO USUARIO
     * @param Request $request
     * @return string
     */
    public static function getNewUser($request)
    {

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/users/form', [
            'title' => 'Cadastrar Usuario',
            'nome' => '',
            'email' => '',
            'status' => self::getStatus($request)

        ]);

        // RETORNA A PÁGNA COMPLETA
        return parent::getPanel('CADASTRAR USUARIO -> WDEV', $content, 'users');

    }

    /**
     * METODO RESPONSÁVEL POR CADASTRAR UM USUARIO NO BANCO DE DADOS
     * @param Request $request
     * @return void 
     */

    public static function setNewUser($request)
    {

        //DADOS DO POST VARS
        $postVars = $request->getPostVars();
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        //VALIDA O EMAIL DO USUÁRIO SE EXISTE EXIBE UM ERRO
        $obUser = EntityUser::getUserByEmail($email);
        if ($obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users/new?status=duplicated');
        }

        //NOVA INSTANCIA DE USUARIO
        $obUser = new EntityUser;
        $obUser->nome = $nome;
        $obUser->email = $email;
        $obUser->senha = password_hash($senha, PASSWORD_DEFAULT);
        $obUser->cadastrar();


        //RETORNA A PÁGINA DE USUARIOS
        // return self::getUsers($request);

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/' . $obUser->id . '/edit?status=created');
    }


    /**
     * MÉTODO REPONSÁVEL POR OBTER OS USUARIOS DO BANCO DE DADOS PARA A PÁGINA
     * O SEGUNDO PARÂMENTO PERMITE PEGAR OS DADOS MESMO FORA DA PAGINATION
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    private static function getUserItens($request, &$obPagination)
    {

        //USUARIOS
        $itens = '';

        //  QUANTIDADE TOTAL DE REGISTROS
        $quantidadeTotal = EntityUser::getUsers(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //INTANCIA DE PAGINAÇÃO
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

        //RESULTADOS DA PÁGINA DE 
        $results = EntityUser::getUsers(null, 'id DESC', $obPagination->getLimit());

        //RENDERIZA O ITEMkkkk 
        while ($obUser = $results->fetchObject(EntityUser::class)) {
            $itens .= View::render('admin/modules/users/item', [
                'id' => $obUser->id,
                'nome' => $obUser->nome,
                'email' => $obUser->email,
            ]);
        }

        //RETORNO DOS USUARIOS
        return $itens;
    }


    /**
     * METODO RESPONSÁVEL POR RETORNAR O FOMRULARIO DE EDIÇÃO DO USUARIO
     * @param Request $request
     * @param integer $id
     * @return string
     */

    public static function getEditUser($request, $id)
    {

        //OBTEM O USUARIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        //CONTEÚDO DO FORMULÁRIO DE EDIÇÃO
        $content = View::render('admin/modules/users/form', [
            'title' => 'Editar usuário',
            'nome' => $obUser->nome,
            'email' => $obUser->email,
            'status' => self::getStatus($request)

        ]);

        // RETORNA A PÁGNA COMPLETA
        return parent::getPanel('Editar Usuario -> WDEV', $content, 'users');
    }


    /**
     * METODO RESPONSÁVEL POR GRAVAR A ATUALIZAÇÃO DE UM USUARIO
     * @param Request $request
     * @param integer $id
     * @return void
     */

    public static function setEditUser($request, $id)
    {

        //OBTEM O USUARIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        //DADOS DO POST VARS
        $postVars = $request->getPostVars();
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';


        //VALIDA O EMAIL DO USUÁRIO SE EXISTE EXIBE UM ERRO
        $obUserEmail = EntityUser::getUserByEmail($email);
        if ($obUserEmail instanceof EntityUser && $obUserEmail->id != $id) {
            $request->getRouter()->redirect('/admin/users/' . $id . '/edit?status=duplicated');
        }

        // ATUALIZA A INSTANCIA 
        $obUser->nome = $nome;
        $obUser->email = $email;
        $obUser->senha = password_hash($senha, PASSWORD_DEFAULT);
        $obUser->atualizar();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users/' . $obUser->id . '/edit?status=updated');

    }

    /**
     * METODO RESPONSÁVEL POR RETORNAR O FOMULARIO DE EXCLUSAO DO USUARIO
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteUser($request, $id)
    {
        //OBTEM O USUARIO DO BANCO DE DADOS
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        //CONTEÚDO DO FORMULÁRIO
        $content = View::render('admin/modules/users/delete', [
            'nome' => $obUser->nome,
            'email' => $obUser->email,

        ]);

        // RETORNA A PÁGNA COMPLETA
        return parent::getPanel('Excluir Usuario -> WDEV', $content, 'users');

    }


    /**
     * METODO RESPOMSÁVEL POR SELECIONAR O USUÁRIO A SER DELETADO
     * @param Request $request
     * @param string $id
     * @return void
     */
    public static function setDeleteUser($request, $id)
    {

        //OBTER O USUARIO
        $obUser = EntityUser::getUserById($id);

        //VALIDA A INSTANCIA
        if (!$obUser instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        //EXCLUI O USUARIO
        $obUser->excluir();

        //REDIRECIONA O USUÁRIO
        $request->getRouter()->redirect('/admin/users?status=deleted');


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

                return Alert::getSuccess('Usuario criado com sucesso');

                break;

            case 'updated':

                return Alert::getSuccess('Usuario atualizado com sucesso');

                break;

            case 'deleted':

                return Alert::getError('Usuario excluido com sucesso');

                break;


            case 'duplicated':

                return Alert::getError('E-mail já cadastrado');

                break;


        }


    }




}