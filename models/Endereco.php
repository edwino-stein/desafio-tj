<?php

namespace app\models;

use app\models\AbstractModel;

class Endereco extends AbstractModel {

    /**
     * Retorna o nome da tabela
     * @return
     */
    public static function tableName()
    { return 'endereco'; }

    /**
     * Retorna o ID do endereço
     * @return int
     */
    public function getId()
    { return $this->getAttribute('id'); }

    /**
     * Retorna o CEP do endereço
     * @return string
     */
    public function getCep()
    { return $this->getAttribute('cep'); }

    /**
     * Retorna o logradouro do endereço
     * @return string
     */
    public function getLogradouro()
    { return $this->getAttribute('logradouro'); }

    /**
     * Retorna o numero de residencia do endereço
     * @return string
     */
    public function getNumero()
    { return $this->getAttribute('numero'); }

    /**
     * Retorna o complemento do endereço
     * @return string
     */
    public function getComplemento()
    { return $this->getAttribute('complemento'); }

    /**
     * Retorna o bairro do endereço
     * @return string
     */
    public function getBairro()
    { return $this->getAttribute('bairro'); }

    /**
     * Rotorna a cidade do endereço
     * @return string
     */
    public function getCidade()
    { return $this->getAttribute('cidade'); }

    /**
     * Retorna o estado do endereço
     * @return string
     */
    public function getEstado()
    { return $this->getAttribute('estado'); }

    /**
     * Define o CEP para o endereço
     * @param string $cep
     */
    public function setCep($cep)
    {
        $this->setAttribute('cep', $cep);
        return $this;
    }

    /**
     * Define o logradouro do endereço
     * @param string $logradouro
     */
    public function setLogradouro($logradouro)
    {
        $this->setAttribute('logradouro', $logradouro);
        return $this;
    }

    /**
     * Define o numero de residencia do endereço
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->setAttribute('numero', $numero);
        return $this;
    }

    /**
     * Define o complemento do endereço
     * @param string $complemento
     */
    public function setComplemento($complemento)
    {
        $this->setAttribute('complemento', $complemento);
        return $this;
    }

    /**
     * Define o bairro do endereço
     * @param string $bairro
     */
    public function setBairro($bairro)
    {
        $this->setAttribute('bairro', $bairro);
        return $this;
    }

    /**
     * Define a cidade do endereço
     * @param string $cidade
     */
    public function setCidade($cidade)
    {
        $this->setAttribute('cidade', $cidade);
        return $this;
    }

    /**
     * Define o estado do endereço
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->setAttribute('estado', $estado);
        return $this;
    }

    /**
     * Cria e inicializa uma instância de Endereco
     * @param  array $d Array associativo com dados para instância
     * @return Endereco
     */
    public static function criarEndereco($d)
    {
        $e = new Self();

        $e->setCep(isset($d['cep']) ? $d['cep'] : null)
          ->setLogradouro(isset($d['logradouro']) ? $d['logradouro'] : null)
          ->setNumero(isset($d['numero']) ? $d['numero'] : null)
          ->setComplemento(isset($d['complemento']) ? $d['complemento'] : null)
          ->setBairro(isset($d['bairro']) ? $d['bairro'] : null)
          ->setCidade(isset($d['cidade']) ? $d['cidade'] : null)
          ->setEstado(isset($d['estado']) ? $d['estado'] : null);

        return $e;
    }
}
