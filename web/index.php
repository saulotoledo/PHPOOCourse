<?php

define('CLASS_DIR', __DIR__ . '/../src/');
set_include_path(get_include_path() . PATH_SEPARATOR . CLASS_DIR);

// The default spl_autoload() behavior lowercases the full path
// and do not works as expected on some systems (e.g. GNU/Linux).
// To fix this, we provide a custom autoload function:
spl_autoload_register(function($name) {
    include str_replace('\\', '/', $name) . '.php';
});

use ST\POO\Model\PessoaFisica;
use ST\POO\Model\PessoaJuridica;

$clientes = array(
    1  => new PessoaFisica('José',    'Rua Desconhecida, 001 - Centro', '(00) 0000-0001', 'jose@email.com',    '000.000.000/01', 3),
    2  => new PessoaFisica('Maria',   'Rua Desconhecida, 002 - Centro', '(00) 0000-0002', 'maria@email.com',   '000.000.000/02', 2),
    3  => new PessoaFisica('Ricardo', 'Rua Desconhecida, 003 - Centro', '(00) 0000-0003', 'ricardo@email.com', '000.000.000/03', 3),
    4  => new PessoaFisica('Carlos',  'Rua Desconhecida, 004 - Centro', '(00) 0000-0004', 'carlos@email.com',  '000.000.000/04', 4),
    5  => new PessoaFisica('Sérgio',  'Rua Desconhecida, 005 - Centro', '(00) 0000-0005', 'sergio@email.com',  '000.000.000/05', 3),
    6  => new PessoaFisica('Alisson', 'Rua Desconhecida, 006 - Centro', '(00) 0000-0006', 'alisson@email.com', '000.000.000/06', 1),
    7  => new PessoaFisica('Lorenzo', 'Rua Desconhecida, 007 - Centro', '(00) 0000-0007', 'lorenzo@email.com', '000.000.000/07', 1),
    8  => new PessoaFisica('Cláudia', 'Rua Desconhecida, 008 - Centro', '(00) 0000-0008', 'claudia@email.com', '000.000.000/08', 3),
    9  => new PessoaFisica('Douglas', 'Rua Desconhecida, 009 - Centro', '(00) 0000-0009', 'douglas@email.com', '000.000.000/09', 5),
    10 => new PessoaFisica('Lorena',  'Rua Desconhecida, 010 - Centro', '(00) 0000-0010', 'lorena@email.com',  '000.000.000/10', 3),
    11 => new PessoaJuridica('Supermercados Barato & Caro S.A.',        'Rua Central, 011 - Centro', '(00) 0000-0011', 'supermercado.bc@pj.com',  '00.000.000/0000-11', 5),
    12 => new PessoaJuridica('DentalProd Produtos Odontológicos Ltda.', 'Rua Central, 012 - Centro', '(00) 0000-0012', 'dentalprod@pj.com',       '00.000.000/0000-12', 3),
);

/* Clientes com endedeços de cobrança definidos: */
$cliente = $clientes[4];
$cliente->setEnderecoDeCobranca('Rua da Cobrança, 004 - Periferia');

$cliente = $clientes[11];
$cliente->setEnderecoDeCobranca('Rua da Cobrança, 011 - Periferia');

$id = (int) filter_input(INPUT_GET, 'id');
$order = filter_input(INPUT_GET, 'order');
$selected = null;

if (!$order) {
    $order = 'asc';
}

if ($order == 'desc') {
    $clientes = array_reverse($clientes, true);
}

$clientesInfo = array();
foreach ($clientes as $key => $cliente) {
    $clientesInfo[$key] = (object) array(
        'id' => $key,
        'nome_razaoSocial' => (($cliente instanceOf PessoaFisica) ? $cliente->getNome() : $cliente->getRazaoSocial()),
        'endereco' => $cliente->getEndereco(),
        'enderecoDeCobranca' => $cliente->getEnderecoDeCobranca(),
        'telefone' => $cliente->getTelefone(),
        'email' => $cliente->getEmail(),
        'cpf_cnpj' => (($cliente instanceOf PessoaFisica) ? $cliente->getCpf() : $cliente->getCnpj()),
        'tipo' => (($cliente instanceOf PessoaFisica) ? 'pessoaFisica' : 'pessoaJuridica'),
        'grauDeImportancia' => $cliente->getGrauDeImportanciaInfo() . ' estrela(s)',
    );
}

$viewVars = (object) array(
    'clientes' => $clientesInfo,
    'selected' => null,
    'strings' => (object) array(
        'pageTitle' => 'Lista de Clientes',
        'fieldLabels' => (object) array(
            'id' => 'ID',
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

if ($id && count($clientes) >= $id) {
    $viewVars->selected = $clientesInfo[$id];
}

include_once '../src/ST/POO/View/clients.php';
