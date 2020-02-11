<?php

require_once 'io-config.php';

// CONTANTES PARA O SISTEMA
// - verificar o arquivo 'io-config.php' com o 'padrão' do sistema

define('DB_HOST', $DB_HOST);
define('DB_USER', $DB_USER);
define('DB_PASS', $DB_PASS);
define('DB_NAME', $DB_NAME);
define('DB_CHARSET', $DB_CHARSET);
define('DB_PORT', $DB_PORT);

define('SHOPPING_VERSAO', '1.00.0');

$conexao = new Conexao();
unset($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);