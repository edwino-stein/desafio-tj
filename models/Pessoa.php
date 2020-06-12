<?php

namespace app\models;

use app\models\AbstractModel;
use app\models\Endereco;
use app\models\PessoaFisica;
use app\models\PessoaJuridica;

class Pessoa extends AbstractModel {

    /**
     * Retorna o nome da tabela
     * @return string
     */
    public static function tableName()
    { return 'pessoa'; }

    /**
     * Retorna a ID da pessoa
     * @return integer
     */
    public function getId()
    { return $this->getAttribute('id'); }

    /**
     * Retorna o código da pessoa (CPF ou CNPJ)
     * @return string
     */
    public function getCp()
    { return $this->getAttribute('cp'); }

    /**
     * Retorna o tipo da pessoa (fisica ou juridica)
     * @return string
     */
    public function getTipo()
    { return $this->getAttribute('tipo'); }

    /**
     * Retorna o nome da pessoa
     * @return string
     */
    public function getNome()
    { return $this->getAttribute('nome'); }

    /**
     * Retorna o endereço da pessoa
     * @return Endereco
     */
    public function getEndereco()
    {
        if(is_int($this->getAttribute('endereco'))){
            return $this->hasOne(Endereco::className(), ['id' => 'endereco'])->one();
        }
        else {
            return $this->getAttribute('endereco');
        }
    }

    /**
    * Retorna a data de nascimento da pessoa
    * @return \DateTime
    */
    public function getNascimento()
    { return new \DateTime($this->getAttribute('nascimento')); }

    /**
    * Retorna o telefone da pessoa
    * @return string
    */
    public function getTelefone()
    { return $this->getAttribute('telefone'); }

    /**
     * Define o nome da pessoa
     * @param Endereco $nome
     */
    public function setNome($nome)
    {
        $this->setAttribute('nome', $nome);
        return $this;
    }

    /**
     * Define o endereço da pessoa
     * @param string $endereco
     */
    public function setEndereco($endereco)
    {
        $this->setAttribute(
            'endereco',
            $endereco->getIsNewRecord() ? $endereco : $endereco->getId()
        );

        return $this;
    }

    /**
    * Define a data de nascimento da pessoa
    * @param DateTime $nascimento
    */
    public function setNascimento($nascimento)
    {
        $this->setAttribute('nascimento', $nascimento->format('Y-m-d'));
        return $this;
    }

    /**
    * Define o nome da pessoa
    * @param string $nascimento
    */
    public function setTelefone($telefone)
    {
        $this->setAttribute('telefone', $telefone);
        return $this;
    }

    public function save ($runValidation = true, $attributeNames = null)
    {
        if(!is_int($this->getEndereco())){
            $e = $this->getEndereco();
            $e->save();
            $this->setEndereco($e);
        }

        return parent::save($runValidation, $attributeNames);
    }

    public static function novaPessoa($data)
    {
        if(isset($data['tipo'])){
            if($data['tipo'] == 'fisica') return PessoaFisica::criarPessoa($data);
            elseif($data['tipo'] == 'jur') return PessoaJuridica::criarPessoa($data);
        }
        return null;
    }

    protected static function initPessoa($p, $d)
    {
        $p->setNome(isset($d['nome']) ? $d['nome'] : null)
          ->setNascimento(isset($d['nascimento']) ? new \DateTime($d['nascimento']) : null)
          ->setTelefone(isset($d['telefone']) ? $d['telefone'] : null);

        $e = null;
        if(isset($d['endereco'])){
            if(is_int($d['endereco'])) $e = Endereco::findOneById($d['endereco']);
            else $e = Endereco::criarEndereco($d['endereco']);
        }

        $p->setEndereco($e);
    }
}
