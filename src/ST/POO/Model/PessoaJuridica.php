<?php

require_once 'ClienteAbstract.php';

class PessoaJuridica extends ClienteAbstract
{
    protected $cnpj;
    protected $razaoSocial;

    /**
     * @param $razaoSocial
     * @param $endereco
     * @param $telefone
     * @param $email
     * @param $cnpj
     * @param $stars
     */
    public function __construct($razaoSocial, $endereco, $telefone, $email, $cnpj, $stars)
    {
        parent::__construct($endereco, $telefone, $email, $stars);
        $this->setCnpj($cnpj);
        $this->setRazaoSocial($razaoSocial);
    }

    /**
     * @return mixed
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param mixed $cnpj
     * @return PessoaJuridica
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }

    /**
     * @param mixed $razaoSocial
     * @return PessoaJuridica
     */
    public function setRazaoSocial($razaoSocial)
    {
        $this->razaoSocial = $razaoSocial;
        return $this;
    }

    /**
     * @param mixed $stars
     * @return PessoaJuridica
     */
    public function setGrauDeImportancia($stars)
    {
        $stars = $this->checkStars($stars);
        $this->grauDeImportanciaInfo = "(VIP) {$stars}";
        return $this;
    }
}
