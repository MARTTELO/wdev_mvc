<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;

//CARREGA VARIÁVEIS DE AMBIENTE
Environment::load(__DIR__ . '/../');

//DEFINE AS CONFIGURAÇÕES DE BANCO DE DADOS
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT'),
);

//DEFINE A CONSTANTE URL DO PROJETO
$url = getenv('URL');
if ($url === false || filter_var($url, FILTER_VALIDATE_URL) === false) {
    throw new RuntimeException('A variável URL do arquivo .env deve conter uma URL absoluta válida.');
}


define('URL', rtrim($url, '/'));


//DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init([
    'URL' => URL,
]);

