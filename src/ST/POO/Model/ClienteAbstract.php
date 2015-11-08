<?php

namespace ST\POO\Model;

abstract class ClienteAbstract implements GrauDeImportanciaInterface, EnderecoDeCobrancaInterface
{
    protected $id;
    protected $nome;
    protected $endereco;
    protected $enderecoDeCobranca;
    protected $telefone;
    protected $email;
    protected $grauDeImportanciaInfo;

    /**
     * @param $id
     * @param $endereco
     * @param $telefone
     * @param $email
     * @param $stars
     */
    public function __construct($endereco, $telefone, $email, $stars)
    {
        $this->setEndereco($endereco);
        $this->setTelefone($telefone);
        $this->setEmail($email);
        $this->setGrauDeImportancia($stars);
    }

    /**
     * @param $stars
     * @return ClienteAbstract
     */
    public abstract function setGrauDeImportancia($stars);

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ClienteAbstract
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * @param mixed $endereco
     * @return ClienteAbstract
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param mixed $telefone
     * @return ClienteAbstract
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return ClienteAbstract
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param mixed $stars
     * @return int
     */
    protected function checkStars($stars)
    {
        $stars = (int) $stars;

        if ($stars < 0) {
            $stars = 0;
        }

        if ($stars > 5) {
            $stars = 5;
        }

        return $stars;
    }

    /**
     * @return mixed
     */
    public function getGrauDeImportanciaInfo()
    {
        return $this->grauDeImportanciaInfo;
    }

    /**
     * @return mixed
     */
    public function getEnderecoDeCobranca()
    {
        return $this->enderecoDeCobranca;
    }

    /**
     * @param mixed $enderecoDeCobranca
     * @return ClienteAbstract
     */
    public function setEnderecoDeCobranca($enderecoDeCobranca)
    {
        $this->enderecoDeCobranca = $enderecoDeCobranca;
        return $this;
    }
}
