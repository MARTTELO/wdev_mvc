<?php

namespace App\Utils;

class View
{

    /**
     * Smetodo responsavel por retornar o conteudo de uma view
     * @param string $view
     * @return string
     */
    private static function getContentView($view)
    {
        // localiza o arquivo da view passado como parametro
        $file = __DIR__ . '/../../resources/view/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * metodo responsavel por retornar uma view renderizada
     * @param string $view
     * @param array $vars (string / numeric)     * @return string
     */


    public static function render($view, $vars = [])
    {
        // conteudo da view
        $contentView = self::getContentView($view);

        //mostrando chaves do Aray de variaveis para o conteudo da view
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);

        // echo "<pre>";
        // print_r($keys);
        // echo "</pre>";


        // mostrando valores do Array de variaveis para o conteudo da view
        $values = array_values($vars);
        // echo "<pre>";
        // print_r($values);
        // echo "</pre>";

        // substitui as chaves pelos valores
        $contentView = str_replace($keys, $values, $contentView);

        // retorna o conteudo da view
        return str_replace($keys, $values, $contentView);
    }

}