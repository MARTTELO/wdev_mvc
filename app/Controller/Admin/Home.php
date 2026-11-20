<?php



namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Http\Request;
use App\Utils\View;


class Home extends Page
{

   /**
    * MÉTODO RESPONSÁVEL POR RETORNAR A VIEW DA HOME
    * @param Request $request
    * @return string
    */
   public static function getHome($request)
   {

      //CONTEÚDO DA HOME
      $content = View::render('admin/modules/home/index', []);

      // RETORNA A PÁGNA COMPLETA
      return parent::getPanel('HOME -> WDEV', $content, 'home');

   }

}