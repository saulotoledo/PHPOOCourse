<?php

define('CLASS_DIR',  __DIR__ . '/src/');
define('CONFIG_DIR', __DIR__ . '/app/config/');

set_include_path(get_include_path() . PATH_SEPARATOR . CLASS_DIR);
spl_autoload_register(function($name) {
    include __DIR__  . '/src/' . str_replace('\\', '/', $name) . '.php';
});

// Load config:
$dbConfig = array();
$dbConfigFilename = CONFIG_DIR . DIRECTORY_SEPARATOR . 'database.php';
$localDbConfigFilename = CONFIG_DIR . DIRECTORY_SEPARATOR . 'database.local.php';
if (file_exists($localDbConfigFilename)) {
    $dbConfig = include $localDbConfigFilename;
} else {
    $dbConfig = include $dbConfigFilename;
}

try {
    /*
    $dbh = new PDO("mysql:host={$dbConfig['hostname']}", $dbConfig['username'], $dbConfig['password']);
    $dbh->exec(
        "CREATE DATABASE `{$dbConfig['database']}`; FLUSH PRIVILEGES;"
    ) or die(print_r($dbh->errorInfo(), true) . "\n");
*/
    $conexao = new ST\POO\Database\Conexao(
        $dbConfig['hostname'],
        $dbConfig['username'],
        $dbConfig['password'],
        $dbConfig['port'],
        $dbConfig['database']
    );
    $conexaoPdo = $conexao->connect();

    $conexaoPdo->exec("
        CREATE TABLE IF NOT EXISTS `pessoasfisicas` (
            `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `nome` VARCHAR(255) NOT NULL,
            `endereco` VARCHAR(255) NOT NULL,
            `enderecoCobranca` VARCHAR(255) NULL,
            `telefone` VARCHAR(20) NOT NULL,
            `email` VARCHAR(150) NOT NULL,
            `cpf` VARCHAR(14) NOT NULL,
            `stars` INT(1) NOT NULL
        );
    ");

    $conexaoPdo->exec("
        CREATE TABLE IF NOT EXISTS `pessoasjuridicas`(
            `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `razaoSocial` VARCHAR(255) NOT NULL,
            `endereco` VARCHAR(255) NOT NULL,
            `enderecoCobranca` VARCHAR(255) NULL,
            `telefone` VARCHAR(20) NOT NULL,
            `email` VARCHAR(150) NOT NULL,
            `cnpj` VARCHAR(18) NOT NULL,
            `stars` INT(1) NOT NULL
        );
    ");

    ST\POO\Fixtures\PopulateDb::load(
        new ST\POO\Database\ObjectManager($conexaoPdo)
    );

    echo "Done!\n";

} catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage() . "\n");
}
