<?php

namespace app\models;

use app\models\AbstractModel;
use app\models\Pessoa;
use app\models\PessoaFisica;
use app\models\PessoaJuridica;
use app\models\Defensor;

class Partes extends AbstractModel {

    /**
     * Retorna o nome da tabela
     * @return string
     */
    public static function tableName()
    { return 'partes'; }

    /**
     * Retorna a ID da partes
     * @return integer
     */
    public function getId()
    { return $this->getAttribute('id'); }

    /**
     * Retorna o autor do processo
     * @return Pessoa
     */
    public function getAutor()
    {
        $pessoa = $this->hasOne(Pessoa::className(), ['id' => 'autor'])->one();
        if($pessoa->getTipo() == 'fisica') return PessoaFisica::findOneById($pessoa->getId());
        else return PessoaJuridica::findOneById($pessoa->getId());
    }

    /**
     * Retorna o reu do processo
     * @return Pessoa
     */
    public function getReu()
    {
        $pessoa = $this->hasOne(Pessoa::className(), ['id' => 'reu'])->one();
        if($pessoa->getTipo() == 'fisica') return PessoaFisica::findOneById($pessoa->getId());
        else return PessoaJuridica::findOneById($pessoa->getId());
    }

    /**
     * Retorna o advogado do autor do processo
     * @return Defensor
     */
    public function getAutorAdvogado()
    { return $this->hasOne(Defensor::className(), ['id' => 'autor_adv'])->one(); }

    /**
     * Retorna o advogado do reu do processo
     * @return Defensor
     */
    public function getReuAdvogado()
    { return $this->hasOne(Defensor::className(), ['id' => 'reu_adv'])->one(); }

    /**
     * Define o autor do processo
     * @param Pessoa $autor
     */
    public function setAutor($autor)
    {
        $this->setAttribute('autor', $autor->getId());
        return $this;
    }

    /**
     * Define o reu do processo
     * @param Pessoa $reu
     */
    public function setReu($reu)
    {
        $this->setAttribute('reu', $reu->getId());
        return $this;
    }

    /**
     * Define o advogado do autor do processo
     * @param Defensor $autorAdv
     */
    public function setAutorAdvogado($autorAdv)
    {
        $this->setAttribute('autor_adv', $autorAdv->getId());
        return $this;
    }

    /**
     * Define o advogado do reu do processo
     * @param Defensor $reuAdv
     */
    public function setReuAdvogado($reuAdv)
    {
        $this->setAttribute('reu_adv', $reuAdv->getId());
        return $this;
    }

    protected function getGettersArrayMap(): array
    {
        $map = parent::getGettersArrayMap();
        $map['autor_adv'] = function($m) { return $m->getAutorAdvogado()->asArray(); };
        $map['reu_adv'] = function($m) { return $m->getReuAdvogado()->asArray(); };
        return $map;
    }

    public static function parsePartes($data)
    {
        $partes = ['autor' => null, 'reu' => null, 'autor_adv' => null, 'reu_adv' => null];
        foreach ($data as $key => $value) {
            if($key == 'autor' || $key == 'reu'){
                $partes[$key] = is_int($value) ? Pessoa::findOneById($value) : Pessoa::novaPessoa($value);
            }
            else if($key == 'autor_adv' || $key == 'reu_adv' && is_int($value)){
                $partes[$key] = Defensor::findOneById($value);
            }
        }

        return $partes;
    }
}
