<?php

namespace ST\POO\Model;

use ST\POO\Database\Conexao;

class ClienteCollection
{
    private $connection;

    public function __construct(Conexao $connection)
    {
        $this->connection = $connection;
    }

    public function getList($order = 'ASC')
    {
        $clientes = array();
        $pdoConnection = $this->connection->connect();

        if ($pdoConnection) {
            $stmt = $pdoConnection->prepare("
                SELECT
                    id, nome, endereco, enderecoCobranca, telefone, email, cpf, null as cnpj, stars
                FROM
                    pessoasfisicas
                UNION ALL (
                    SELECT
                        id, razaoSocial as nome, endereco, enderecoCobranca, telefone, email, null as cpf, cnpj, stars
                    FROM
                        pessoasjuridicas
                ) ORDER BY
                    nome {$order}
            ");

            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($result as $cliente) {
                $clienteObject = null;

                if ($cliente['cpf']) {
                    $clienteObject = new PessoaFisica(
                        $cliente['nome'],
                        $cliente['endereco'],
                        $cliente['telefone'],
                        $cliente['email'],
                        $cliente['cpf'],
                        $cliente['stars']
                    );
                } else {
                    $clienteObject = new PessoaJuridica(
                        $cliente['nome'],
                        $cliente['endereco'],
                        $cliente['telefone'],
                        $cliente['email'],
                        $cliente['cnpj'],
                        $cliente['stars']
                    );
                }
                $clienteObject
                    ->setId($cliente['id'])
                    ->setEnderecoDeCobranca($cliente['enderecoCobranca'])
                ;
                $clientes[] = $clienteObject;
            }
        }

        return $clientes;
    }
}
