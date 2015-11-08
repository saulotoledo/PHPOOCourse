<?php

namespace ST\POO\Fixtures;

use ST\POO\Database\FixtureInterface;
use ST\POO\Database\ObjectManager;
use ST\POO\Model\PessoaFisica;
use ST\POO\Model\PessoaJuridica;

class PopulateDb implements FixtureInterface
{
    public static function load(ObjectManager $manager)
    {
        $clientes = array(
            new PessoaFisica('José',    'Rua Desconhecida, 001 - Centro', '(00) 0000-0001', 'jose@email.com',    '000.000.000/01', 3),
            new PessoaFisica('Maria',   'Rua Desconhecida, 002 - Centro', '(00) 0000-0002', 'maria@email.com',   '000.000.000/02', 2),
            new PessoaFisica('Ricardo', 'Rua Desconhecida, 003 - Centro', '(00) 0000-0003', 'ricardo@email.com', '000.000.000/03', 3),
            new PessoaFisica('Carlos',  'Rua Desconhecida, 004 - Centro', '(00) 0000-0004', 'carlos@email.com',  '000.000.000/04', 4),
            new PessoaFisica('Sérgio',  'Rua Desconhecida, 005 - Centro', '(00) 0000-0005', 'sergio@email.com',  '000.000.000/05', 3),
            new PessoaFisica('Alisson', 'Rua Desconhecida, 006 - Centro', '(00) 0000-0006', 'alisson@email.com', '000.000.000/06', 1),
            new PessoaFisica('Lorenzo', 'Rua Desconhecida, 007 - Centro', '(00) 0000-0007', 'lorenzo@email.com', '000.000.000/07', 1),
            new PessoaFisica('Cláudia', 'Rua Desconhecida, 008 - Centro', '(00) 0000-0008', 'claudia@email.com', '000.000.000/08', 3),
            new PessoaFisica('Douglas', 'Rua Desconhecida, 009 - Centro', '(00) 0000-0009', 'douglas@email.com', '000.000.000/09', 5),
            new PessoaFisica('Lorena',  'Rua Desconhecida, 010 - Centro', '(00) 0000-0010', 'lorena@email.com',  '000.000.000/10', 3),
            new PessoaJuridica('Supermercados Barato & Caro S.A.',        'Rua Central, 011 - Centro', '(00) 0000-0011', 'supermercado.bc@pj.com',  '00.000.000/0000-11', 5),
            new PessoaJuridica('DentalProd Produtos Odontológicos Ltda.', 'Rua Central, 012 - Centro', '(00) 0000-0012', 'dentalprod@pj.com',       '00.000.000/0000-12', 3),
        );

        /* Clientes com endedeços de cobrança definidos: */
        $cliente = $clientes[4];
        $cliente->setEnderecoDeCobranca('Rua da Cobrança, 004 - Periferia');

        $cliente = $clientes[11];
        $cliente->setEnderecoDeCobranca('Rua da Cobrança, 011 - Periferia');

        foreach($clientes as $cliente) {
            $manager->persist($cliente);
        }

        $manager->flush();
    }
}
