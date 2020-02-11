<?php
//define('DESENVOLVIMENTO', false);

mb_internal_encoding('UTF8');
mb_regex_encoding('UTF8');

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-Type: text/html; charset=utf-8");

date_default_timezone_set('America/Sao_Paulo');

function __autoload($class)
{
    $arquivo = __DIR__ . '/_inc/model/class.' . strtolower($class) . '.php';

    if (file_exists($arquivo)) {
        include_once($arquivo);
    } else {
        echo "A classe '$class' não foi encontrada.";
        exit;
    }
}

// PARA CONSTANSTES DO SISTEMA (io.php)
//$SISTEMA_URL = 'http://www.shopping.com.br/';
//$SISTEMA_REGPORPAGINA = 50;
//$SISTEMA_HISTORICOPORPAGINA = 20;

$DB_HOST = "localhost";
$DB_USER = 'root';
$DB_PASS = "1409";
$DB_NAME = "shopping";
$DB_CHARSET = "utf8";
$DB_PORT = "3306";