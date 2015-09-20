<?php

require_once '../src/ST/POO/Model/Cliente.php';

$clientes = array(
    1  => new Cliente('José',    'Rua Desconhecida, 001 - Centro', '(00) 0000-0001', 'jose@email.com',    '000.000.000/01'),
    2  => new Cliente('Maria',   'Rua Desconhecida, 002 - Centro', '(00) 0000-0002', 'maria@email.com',   '000.000.000/02'),
    3  => new Cliente('Ricardo', 'Rua Desconhecida, 003 - Centro', '(00) 0000-0003', 'ricardo@email.com', '000.000.000/03'),
    4  => new Cliente('Carlos',  'Rua Desconhecida, 004 - Centro', '(00) 0000-0004', 'carlos@email.com',  '000.000.000/04'),
    5  => new Cliente('Sérgio',  'Rua Desconhecida, 005 - Centro', '(00) 0000-0005', 'sergio@email.com',  '000.000.000/05'),
    6  => new Cliente('Alisson', 'Rua Desconhecida, 006 - Centro', '(00) 0000-0006', 'alisson@email.com', '000.000.000/06'),
    7  => new Cliente('Lorenzo', 'Rua Desconhecida, 007 - Centro', '(00) 0000-0007', 'lorenzo@email.com', '000.000.000/07'),
    8  => new Cliente('Cláudia', 'Rua Desconhecida, 008 - Centro', '(00) 0000-0008', 'claudia@email.com', '000.000.000/08'),
    9  => new Cliente('Douglas', 'Rua Desconhecida, 009 - Centro', '(00) 0000-0009', 'douglas@email.com', '000.000.000/09'),
    10 => new Cliente('Lorena',  'Rua Desconhecida, 010 - Centro', '(00) 0000-0010', 'lorena@email.com',  '000.000.000/10'),
);

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
        'nome' => $cliente->getNome(),
        'endereco' => $cliente->getEndereco(),
        'telefone' => $cliente->getTelefone(),
        'email' => $cliente->getEmail(),
        'cpf' => $cliente->getCpf(),
    );
}

$viewVars = (object) array(
    'clientes' => $clientesInfo,
    'selected' => null,
    'strings' => (object) array(
        'pageTitle' => 'Lista de Clientes',
        'fieldLabels' => (object) array(
            'id' => 'ID',
            'nome' => 'Nome',
            'endereco' => 'Endereço',
            'telefone' => 'Telefone',
            'email' => 'E-mail',
            'cpf' => 'CPF',
        ),
    ),
    'order' => $order
);

//var_dump($clientes);

if ($id && count($clientes) >= $id) {
    $viewVars->selected = $clientesInfo[$id];
}

include_once '../src/ST/POO/View/clients.php';
