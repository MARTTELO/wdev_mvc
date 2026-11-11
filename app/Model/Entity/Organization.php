<?php

namespace App\Model\Entity;

class Organization
{
    public $id = 1;

    public $name = 'WDEV';

    public $site = 'www.wdevoficial.com';


    public $description = 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel tincidunt lacinia, nunc nisl aliquam nunc, eget aliquam nisl nunc vel nisl. Sed euismod, nisl vel tincidunt lacinia, nunc nisl aliquam nunc, eget aliquam nisl nunc vel nisl.';

    /* METODO RESPONSAVEL POR RETORNAR O NOME DA EMPRESA
     * @return string
     */
    public static function getName()
    {
        return 'WDEV';
    }

    /**
     * METODO RESPONSAVEL POR RETORNAR A DESCRIÇÃO DA EMPRESA
     * @return string
     */


}