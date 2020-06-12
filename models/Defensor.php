<?php

namespace app\models;

use app\models\Pessoa;
use app\models\AbstractModel;

class Defensor extends AbstractModel {

    /**
     * Retorna o nome da tabela
     * @return string
     */
    public static function tableName()
    { return 'defensor'; }

    /**
     * Retorna a ID do defensor
     * @return integer
     */
    public function getId()
    { return $this->getAttribute('id'); }

    /**
     * Retorna a pessoa do defensor
     * @return Pessoa
     */
    public function getPessoa()
    { return $this->hasOne(Pessoa::className(), ['id' => 'pessoa'])->one(); }

    /**
     * Retorna a inscrição na OAB do defensor
     * @return string
     */
    public function getOab()
    { return $this->getAttribute('oab'); }

    /**
     * Define a pessoa do defensor
     * @param Pessoa $pessoa
     */
    public function setPessoa($pessoa)
    {
        $this->setAttribute('pessoa', $pessoa->getId());
        return $this;
    }

    /**
     * Define a inscrição na OAB do defensor
     * @param string $oab
     */
    public function setOab($oab)
    {
        $this->setAttribute('oab', $oab);
        return $this;
    }
}
