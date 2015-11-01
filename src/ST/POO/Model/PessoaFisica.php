<?php

namespace ST\POO\Model;

class PessoaFisica extends ClienteAbstract
{
    protected $cpf;

    /**
     * @param $nome
     * @param $endereco
     * @param $telefone
     * @param $email
     * @param $cpf
     * @param $stars
     */
    public function __construct($nome, $endereco, $telefone, $email, $cpf, $stars)
    {
        parent::__construct($endereco, $telefone, $email, $stars);
        $this->setNome($nome);
        $this->setCpf($cpf);
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     * @return PessoaFisica
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     * @return PessoaFisica
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * @param mixed $stars
     * @return PessoaFisica
     */
    public function setGrauDeImportancia($stars)
    {
        $stars = $this->checkStars($stars);
        $this->grauDeImportanciaInfo = $stars;
        return $this;
    }
}
