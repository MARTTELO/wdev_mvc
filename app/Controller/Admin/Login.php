<?php


namespace App\Controller\Admin;
use App\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\User;
use App\Utils\View;
use App\Session\Admin\Login as SessionAdminLogin;


class Login extends Page
{


   /**
    * METODO RESPOSAVEL POR RETORNAR A RENDERIZAÇÃO DA PAGINA DE LOGIN
    * @param Request $request
    * @param string $errorMessage
    * @return string
    */
   public static function getLogin($request, $errorMessage = null)
   {

      //STATUS
      $status = !is_null($errorMessage) ? View::render('admin/login/status', [
         'mensagem' => $errorMessage
      ]) : '';

      // $objLogin = new Login;

      // CONTEUDO DA PÁGINA DE LOGIN
      $content = View::render('admin/login', [
         'status' => $status
      ]);

      // RETORNA A PAGINA COMPLETA DE LOGIN
      return parent::getPage('LOGIN > WDEV', $content);
   }

   /**
    * MÉTODO RESPONSAVEL POR DEFINIRUM USUÁRIO
    */
   public static function setLogin($request)
   {

      //POST VARR
      $postVars = $request->getPostVars();
      $email = $postVars['email'] ?? '';
      $senha = $postVars['senha'] ?? '';

      //BUSCAR USUÁRIO PELO EMAIL
      $obUser = User::getUserByRmail($email);

      if (!$obUser instanceof User) {
         return self::getLogin($request, 'E-mail ou senha inválidos');

      }

      //VERIFICA A SENHA DO USUARIO COM A DO BANCO
      if (!password_verify($senha, $obUser->senha)) {
         return self::getLogin($request, 'E-mail ou senha inválidos');
      }

      // echo '<pre>';
      // print_r($obUser);
      // echo '</pre>';


      //CRIA A SESSAO DE LOGIN
      SessionAdminLogin::login($obUser);



      //REDIRECIONA O USUÁRIOS PARA A HOME DO ADMIN
      $request->getRouter()->redirect('/admin');
   }

   /**
    * METODO REPONSAVEL POR DESLOGAR O USUARIO
    *  * @param  $request
    * @return void
    */
   public static function setLogout($request)
   {

      //DESTROI A SESSAO DE LOGIN
      SessionAdminLogin::logout();

      //REDIRECIONA O USUÁRIOS PARA A TELA DO ADMIN
      $request->getRouter()->redirect('/admin/login');



   }

}