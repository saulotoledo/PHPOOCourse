<?php

namespace ST\POO\Database;

use ST\POO\Model\ClienteAbstract;
use ST\POO\Model\PessoaFisica;
use ST\POO\Model\PessoaJuridica;

class ObjectManager
{
    private $conexao;
    private $clientes;

    public function __construct(\PDO $conexao)
    {
        $this->conexao = $conexao;
        $this->clientes = array();
    }

    public function persist(ClienteAbstract $cliente)
    {
        $this->clientes[] = $cliente;
    }

    public function flush()
    {
        foreach ($this->clientes as $cliente) {
            try {
                if ($cliente instanceof PessoaFisica) {
                    $stmt = $this->conexao->prepare("
                        INSERT INTO pessoasfisicas(
                            nome,
                            endereco,
                            enderecoCobranca,
                            telefone,
                            email,
                            cpf,
                            stars
                        ) VALUES(
                            :nome,
                            :endereco,
                            :enderecoCobranca,
                            :telefone,
                            :email,
                            :cpf,
                            :stars
                        )
                    ");
                    $stmt->bindParam(":nome", $cliente->getNome());
                    $stmt->bindParam(":cpf",  $cliente->getCpf());

                } else if ($cliente instanceof PessoaJuridica) {

                    $stmt = $this->conexao->prepare("
                        INSERT INTO pessoasjuridicas(
                            razaoSocial,
                            endereco,
                            enderecoCobranca,
                            telefone,
                            email,
                            cnpj,
                            stars
                        ) VALUES (
                            :razaoSocial,
                            :endereco,
                            :enderecoCobranca,
                            :telefone,
                            :email,
                            :cnpj,
                            :stars
                        )
                    ");

                    $stmt->bindParam(":razaoSocial", $cliente->getRazaoSocial());
                    $stmt->bindValue(":cnpj", $cliente->getCnpj());
                }

                $stmt->bindParam(":endereco", $cliente->getEndereco());
                $stmt->bindParam(":enderecoCobranca", $cliente->getEnderecoDeCobranca());
                $stmt->bindParam(":telefone", $cliente->getTelefone());
                $stmt->bindParam(":email", $cliente->getEmail());
                $stmt->bindValue(":stars", $cliente->getGrauDeImportanciaInfo());

                if (!$stmt->execute()) {
                    print_r($stmt->errorInfo());
                }

            } catch (\PDOException $ex) {
                echo "Erro ao inserir dados: " . $ex->getMessage();
            }
        }
    }
}
