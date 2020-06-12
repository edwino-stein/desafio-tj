<?php

namespace app\models;

use app\models\AbstractModel;
use app\models\PessoaFisica;
use app\models\Vara;

class Magistrado extends AbstractModel {

    /**
     * Retorna o nome da tabela
     * @return string
     */
    public static function tableName()
    { return 'magistrado'; }

    /**
     * Retorna a ID do magistrado
     * @return integer
     */
    public function getId()
    { return $this->getAttribute('id'); }

    /**
     * Retorna a pessoa do magistrado
     * @return PessoaFisica
     */
    public function getPessoa()
    { return $this->hasOne(PessoaFisica::className(), ['id' => 'pessoa'])->one(); }

    /**
     * Retorna a vara do magistrado
     * @return Vara
     */
    public function getVara()
    { return $this->hasOne(Vara::className(), ['id' => 'vara'])->one(); }

    /**
     * Define a pessoa do magistrado
     * @param PessoaFisicas $pessoa
     */
    public function setPessoa($pessoa)
    {
        $this->setAttribute('pessoa', $pessoa->getId());
        return $this;
    }

    /**
     * Define a vara do magistrado
     * @param Vara $vara
     */
    public function setVara($vara)
    {
        $this->setAttribute('vara', $vara->getId());
        return $this;
    }

    /**
     * Filtra os juizes por vara
     * @param  Vara $vara Vara selecionada para filtro
     * @return array
     */
    public static function findByVara($vara)
    {
        return Self::find()->where(['vara' => $vara->getId()])->all();
    }
}
