<?php

namespace app\models;

use app\models\Pessoa;

class PessoaJuridica extends Pessoa {

    /**
     * Retorna o nome da tabela
     * @return string
     */
    public static function tableName()
    { return 'pessoa_juridica'; }

    public function __construct ()
    {
        $this->setAttribute('tipo', 'juridica');
    }

    /**
     * Retorna o CNPJ da pessoa juridica
     * @return string
     */
    public function getCnpj()
    { return $this->getCp(); }

    /**
     * Retorna o nome fantasia da pessoa juridica
     * @return string
     */
    public function getNomeFantasia()
    { return $this->getAttribute('fantasia'); }

    /**
     * Retorna a inscrição estadual da pessoa juridica
     * @return string
     */
    public function getInscricaoEstadual()
    { return $this->getAttribute('inscricao'); }

    /**
     * Define o CNPJ da pessoa juridica
     * @param string $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->setAttribute('cp', $cnpj);
        return $this;
    }

    /**
     * Define o nome fantasia da pessoa juridica
     * @param string $nomeFantasia
     */
    public function setNomeFantasia($nomeFantasia)
    {
        $this->setAttribute('fantasia', $nomeFantasia);
        return $this;
    }

    /**
     * Define a inscrição estadual da pessoa juridica
     * @param string $nomeFantasia
     */
    public function setInscricaoEstadual($inscricaoEstadual)
    {
        $this->setAttribute('inscricao', $inscricaoEstadual);
        return $this;
    }

    protected function getGettersArrayMap(): array
    {
        $map = parent::getGettersArrayMap();
        $map['cp'] = function($m) { return $m->getCnpj(); };
        return $map;
    }

    public static function criarPessoa($d)
    {
        $p = new Self();

        Pessoa::initPessoa($p, $d);

        $p->setCnpj(isset($d['cp']) ? $d['cp'] : null)
          ->setNomeFantasia(isset($d['fantasia']) ? $d['fantasia'] : null);

        return $p;
    }
}
