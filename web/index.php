<?php

define('CLASS_DIR',  __DIR__ . '/../src/');
define('CONFIG_DIR', __DIR__ . '/../app/config/');

set_include_path(get_include_path() . PATH_SEPARATOR . CLASS_DIR);

// The default spl_autoload() behavior lowercases the full path
// and do not works as expected on some systems (e.g. GNU/Linux).
// To fix this, we provide a custom autoload function:
spl_autoload_register(function($name) {
    include str_replace('\\', '/', $name) . '.php';
});

use ST\POO\Model\PessoaFisica;
use ST\POO\Model\PessoaJuridica;
use ST\POO\Model\ClienteCollection;
use ST\POO\Database\Conexao;

// Load config:
$dbConfig = array();
$dbConfigFilename = CONFIG_DIR . DIRECTORY_SEPARATOR . 'database.php';
$localDbConfigFilename = CONFIG_DIR . DIRECTORY_SEPARATOR . 'database.local.php';
if (file_exists($localDbConfigFilename)) {
    $dbConfig = include $localDbConfigFilename;
} else {
    $dbConfig = include $dbConfigFilename;
}

// Creating db connection object:
$conexao = new Conexao(
    $dbConfig['hostname'],
    $dbConfig['username'],
    $dbConfig['password'],
    $dbConfig['port'],
    $dbConfig['database']
);


$id = (int) filter_input(INPUT_GET, 'id');
$order = filter_input(INPUT_GET, 'order');
$tipo  = filter_input(INPUT_GET, 'tipo');
if (!$tipo) {
    $id = null;
}
$selected = null;

if (!$order) {
    $order = 'asc';
}

$clienteCollection = new ClienteCollection($conexao);
$clientes = $clienteCollection->getList($order);

$clientesInfo = array();
$selectedClient = null;

for ($i = 0; $i < count($clientes); $i++) {

    $cliente = $clientes[$i];

    $clientesInfo[$i] = (object) array(
        'id' => $cliente->getId(),
        'nome_razaoSocial' => (($cliente instanceOf PessoaFisica) ? $cliente->getNome() : $cliente->getRazaoSocial()),
        'endereco' => $cliente->getEndereco(),
        'enderecoDeCobranca' => $cliente->getEnderecoDeCobranca(),
        'telefone' => $cliente->getTelefone(),
        'email' => $cliente->getEmail(),
        'cpf_cnpj' => (($cliente instanceOf PessoaFisica) ? $cliente->getCpf() : $cliente->getCnpj()),
        'tipo' => (($cliente instanceOf PessoaFisica) ? 'pessoaFisica' : 'pessoaJuridica'),
        'grauDeImportancia' => $cliente->getGrauDeImportanciaInfo() . ' estrela(s)',
    );

    if ($id && $tipo) {
        if ($id == $cliente->getId()) {
            if ($cliente instanceOf PessoaFisica && $tipo == 'pessoaFisica') {
                $selectedClient = $clientesInfo[$i];
            }

            if ($cliente instanceOf PessoaJuridica && $tipo == 'pessoaJuridica') {
                $selectedClient = $clientesInfo[$i];
            }
        }
    }
}

$viewVars = (object) array(
    'clientes' => $clientesInfo,
    'selected' => null,
    'strings' => (object) array(
        'pageTitle' => 'Lista de Clientes',
        'fieldLabels' => (object) array(
            'id' => 'ID de registro (por tipo)',
            'nome_razaoSocial' => 'Nome / Razão Social',
            'endereco' => 'Endereço',
            'enderecoDeCobranca' => 'Endereço de Cobrança',
            'telefone' => 'Telefone',
            'email' => 'E-mail',
            'cpf_cnpj' => 'CPF / CNPJ',
            'tipo' => 'Tipo',
            'grauDeImportancia' => 'Grau de Importância'
        ),
        'otherLabels' => (object) array(
            'pessoaFisica' => 'Pessoa Física',
            'pessoaJuridica' => 'Pessoa Jurídica',
        ),
    ),
    'order' => $order
);

if ($selectedClient) {
    $viewVars->selected = $selectedClient;
}

include_once __DIR__. '/../src/ST/POO/View/clients.php';
