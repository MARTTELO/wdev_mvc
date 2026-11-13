<?php

namespace App\Utils;

class View
{

    /**
     * VARIÁVEIS PADRÕES DA VIEW
     * @var array
     */
    private static $vars = [];


    /**
     * MÉTODO RESPONSÁVEL POR DEFINIR OS DADOS INICIAIS DA CLASSE
     * @param array $vars
     * @return void
     */
    public static function init($vars = [])
    {
        self::$vars = $vars;
    }


    /**
     * METODO RESPONSAVEL POR RETORNAR O CONTEUDO DE UMA VIEW
     * @param string $view
     * @return string
     */
    private static function getContentView($view)
    {
        // LOCALIZA O ARQUIVO DA VIEW PASSADO COMO PARAMETRO
        $file = __DIR__ . '/../../resources/view/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * METODO RESPONSAVEL POR RETORNAR UMA VIEW RENDERIZADA
     * @param string $view
     * @param array $vars (string / numeric)     * @return string
     */


    public static function render($view, $vars = [])
    {
        // CONTEUDO DA VIEW
        $contentView = self::getContentView($view);

        //MERGE DE VARIAVEIS DA VIEW
        $vars = array_merge(self::$vars, $vars);

        //MOSTRANDO CHAVES DO ARAY DE VARIAVEIS PARA O CONTEUDO DA VIEW
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);

        // echo "<pre>";
        // print_r($keys);
        // echo "</pre>";


        // MOSTRANDO VALORES DO ARRAY DE VARIAVEIS PARA O CONTEUDO DA VIEW
        $values = array_values($vars);
        // echo "<pre>";
        // print_r($values);
        // echo "</pre>";

        // SUBSTITUI AS CHAVES PELOS VALORES
        $contentView = str_replace($keys, $values, $contentView);

        // RETORNA O CONTEUDO DA VIEW
        return str_replace($keys, $values, $contentView);
    }

}