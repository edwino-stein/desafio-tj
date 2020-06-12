<?php

namespace app\models;

use app\models\Pessoa;

class PessoaFisica extends Pessoa {

    /**
     * Retorna o nome da tabela
     * @return string
     */
    public static function tableName()
    { return 'pessoa_fisica'; }

    public function __construct ()
    {
        $this->setAttribute('tipo', 'fisica');
    }

    /**
     * Retorna o CPF da pessoa fisica
     * @return string
     */
    public function getCpf()
    { return $this->getCp(); }

    /**
     * Retorna o sexo da pessoa fisica
     * @return string
     */
    public function getSexo()
    { return $this->getAttribute('sexo'); }

    /**
     * Retorna o RG da pessoa fisica
     * @return string
     */
    public function getRg()
    { return $this->getAttribute('rg'); }

    /**
     * Retorna a nacionalidade da pessoa fisica
     * @return string
     */
    public function getNacionalidade()
    { return $this->getAttribute('nacionalidade'); }

    /**
     * Retorna o estado civil da pessoa fisica
     * @return string
     */
    public function getEstadoCivil()
    { return $this->getAttribute('estado_civil'); }

    /**
     * Retorna a profissao da pessoa fisica
     * @return string
     */
    public function getProfissao()
    { return $this->getAttribute('profissao'); }

    /**
     * Define o CPF da pessoa fisica
     * @param string $cpf
     */
    public function setCpf($cpf)
    {
        $this->setAttribute('cp', $cpf);
        return $this;
    }

    /**
     * Define o sexo da pessoa fisica
     * @param string $sexo
     */
    public function setSexo($sexo)
    {
        $this->setAttribute('sexo', $sexo);
        return $this;
    }

    /**
     * Define o RG da pessoa fisica
     * @param string $rg
     */
    public function setRg($rg)
    {
        $this->setAttribute('rg', $rg);
        return $this;
    }

    /**
     * Define a nacionalidade da pessoa fisica
     * @param string $nacionalidade
     */
    public function setNacionalidade($nacionalidade)
    {
        $this->setAttribute('nacionalidade', $nacionalidade);
        return $this;
    }

    /**
     * Define o estado civil da pessoa fisica
     * @param string $estadoCivil
     */
    public function setEstadoCivil($estadoCivil)
    {
        $this->setAttribute('estado_civil', $estadoCivil);
        return $this;
    }

    /**
     * Define a profissao da pessoa fisica
     * @param string $profissao
     */
    public function setProfissao($profissao)
    {
        $this->setAttribute('profissao', $profissao);
        return $this;
    }

    protected function getGettersArrayMap(): array
    {
        $map = parent::getGettersArrayMap();
        $map['cp'] = function($m) { return $m->getCpf(); };
        return $map;
    }

    public static function criarPessoa($d)
    {
        $p = new Self();

        Pessoa::initPessoa($p, $d);

        $p->setCpf(isset($d['cp']) ? $d['cp'] : null)
          ->setSexo(isset($d['sexo']) ? $d['sexo'] : null)
          ->setRg(isset($d['rg']) ? $d['rg'] : null)
          ->setNacionalidade(isset($d['nacionalidade']) ? $d['nacionalidade'] : null)
          ->setEstadoCivil(isset($d['estado_civil']) ? $d['estado_civil'] : null)
          ->setProfissao(isset($d['profissao']) ? $d['profissao'] : null);

        return $p;
    }
}
