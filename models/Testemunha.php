<?php

namespace app\models;

use app\models\AbstractModel;
use app\models\PessoaFisica;
use app\models\Processo;

class Testemunha extends AbstractModel {

    /**
     * Retorna o nome da tabela
     * @return string
     */
    public static function tableName()
    { return 'testemunha'; }

    /**
     * Retorna a ID da testemunha
     * @return integer
     */
    public function getId()
    { return $this->getAttribute('id'); }

    /**
     * Retorna a pessoa
     * @return PessoaFisica
     */
    public function getPessoa()
    { return $this->hasOne(PessoaFisica::className(), ['id' => 'pessoa'])->one(); }

    /**
     * Retorna o processo
     * @return Processo
     */
    public function getProcesso()
    { return $this->hasOne(Processo::className(), ['id' => 'processo'])->one(); }

    /**
     * Retorna o tipo de testemunha (ataque ou defesa)
     * @return string
     */
    public function getTipo()
    { return $this->getAttribute('tipo'); }

    /**
     * Define a pessoa com testemunha
     * @param PessoaFisicas $pessoa
     */
    public function setPessoa($pessoa)
    {
        $this->setAttribute('pessoa', $pessoa->getId());
        return $this;
    }

    /**
     * Define o processo
     * @param Processo $processo
     */
    public function setProcesso($processo)
    {
        $this->setAttribute('processo', $processo->getId());
        return $this;
    }

    /**
     * Define o tipo de testemunha
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->setAttribute('tipo', $tipo);
        return $this;
    }

    public static function findByProcesso($processo)
    {
        return Self::find()->where(['processo' => $processo->getId()])->all();
    }

    public static function parseTestemunhas($d)
    {
        $testemunhas = [];
        foreach ($d as $t) {
            $testemunhas[] = [
                'tipo' => $t['tipo'],
                'pessoa' => is_int($t['pessoa']) ?
                    PessoaFisica::findOneById($t['pessoa']) :
                    PessoaFisica::criarPessoa($t['pessoa'])
            ];
        }

        return $testemunhas;
    }

    public static function criarTestemunha($d, $processo)
    {
        $t = new Self();

        if($d['pessoa']->getIsNewRecord()) $d['pessoa']->save();

        $t->setPessoa($d['pessoa'])
          ->setProcesso($processo)
          ->setTipo($d['tipo']);

        return $t;
    }
}
