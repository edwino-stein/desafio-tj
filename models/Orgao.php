<?php

namespace app\models;

use app\models\Endereco;
use app\models\AbstractModel;

class Orgao extends AbstractModel {

    /**
     * Retorna o nome da tabela
     * @return string
     */
    public static function tableName()
    { return 'orgao'; }


    /**
     * Retorna a ID do orgão
     * @return integer
     */
    public function getId()
    { return $this->getAttribute('id'); }

    /**
     * Retorna o nome do orgão
     * @return string
     */
    public function getNome()
    { return $this->getAttribute('nome'); }

    /**
     * Retorna o endereço do orgão
     * @return Endereco
     */
    public function getEndereco()
    { return $this->hasOne(Endereco::className(), ['id' => 'endereco'])->one(); }

    /**
     * Define o nome do orgao
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->setAttribute('nome', $nome);
        return $this;
    }

    /**
     * Define o endereço do orgao
     * @param Endereco $endereco
     */
    public function setEndereco($endereco)
    {
        $this->setAttribute('endereco', $endereco->getId());
        return $this;
    }
}
