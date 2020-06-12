<?php

namespace app\models;

use app\models\AbstractModel;
use app\models\Magistrado;
use app\models\Orgao;
use app\models\Partes;
use app\models\Testemunha;
use yii\helpers\ArrayHelper;

class Processo extends AbstractModel {

    /**
     * Retorna o nome da tabela
     * @return string
     */
    public static function tableName()
    { return 'processo'; }

    public function __construct ($vara)
    {
        //Guarda a data de agora
        $hoje = new \DateTime('now');

        //Pega a ultima data e sequencia da vara
        $ultimoDt = $vara->getUltimoNumeroDt();
        $seq = $vara->getUltimoNumeroSeq() + 1;

        //Se as datas forem diferentes, reinicia a sequencia
        if($hoje->format('Y-m-d') != $ultimoDt->format('Y-m-d')) $seq = 0;

        //Gera o número do processo
        //Padrão: VVVVVYYYYMMDDSSSSSSS
        //VVVVV = id da vara com zeros a esquerda
        //YYYYMMDD = data com ano, mes e dia
        //SSSSSSS = sequencia com zeros a esquerda
        $novoNumero = str_pad($vara->getId(), 5, "0", STR_PAD_LEFT);
        $novoNumero .= $hoje->format('Ymd');
        $novoNumero .= str_pad($seq, 7, "0", STR_PAD_LEFT);

        //Define os atributos do processo
        $this->setAttribute('numero', $novoNumero);
        $this->setAttribute('distribuicao', $hoje->format('Y-m-d'));

        //Atualiza a vara
        $vara->setUltimoNumeroDt($hoje);
        $vara->setUltimoNumeroSeq($seq);
    }

    /**
     * Retorna a ID do processo
     * @return integer
     */
    public function getId()
    { return $this->getAttribute('id'); }

    /**
     * Retorna o número do processo
     * @return string
     */
    public function getNumero()
    { return $this->getAttribute('numero'); }

    /**
     * Retorna a data da distribuição do processo
     * @return \DateTime
     */
    public function getDistribuicao()
    { return new \DateTime($this->getAttribute('distribuicao')); }

    /**
     * Retorna o juiz do processo
     * @return Magistrado
     */
    public function getJuiz()
    { return $this->hasOne(Magistrado::className(), ['id' => 'juiz'])->one(); }

    /**
     * Retorna o orgão do processo
     * @return Orgao
     */
    public function getOrgao()
    { return $this->hasOne(Orgao::className(), ['id' => 'orgao'])->one(); }

    /**
     * Retorna as partes do processo
     * @return Partes
     */
    public function getPartes()
    { return $this->hasOne(Partes::className(), ['id' => 'partes'])->one(); }

    /**
     * Retorna o assunto do processo
     * @return string
     */
    public function getAssunto()
    { return $this->getAttribute('assunto'); }

    /**
     * Retorna os fatos do processo
     * @return string
     */
    public function getFatos()
    { return $this->getAttribute('fatos'); }

    /**
     * Retorna os pedidos do processo
     * @return string
     */
    public function getPedidos()
    { return $this->getAttribute('pedidos'); }

    /**
     * Retorna o valor do processo
     * @return double
     */
    public function getValor()
    { return $this->getAttribute('valor'); }

    /**
    * Define o juiz do processo
    * @param Magistrado $juiz
    */
    public function setJuiz($juiz)
    {
        $this->setAttribute('juiz', $juiz->getId());
        return $this;
    }

    /**
    * Define o orgão do processo
    * @param Orgao $orgao
    */
    public function setOrgao($orgao)
    {
        $this->setAttribute('orgao', $orgao->getId());
        return $this;
    }

    /**
    * Define as partes do processo
    * @param Partes $partes
    */
    public function setPartes($partes)
    {
        $this->setAttribute('partes', $partes->getId());
        return $this;
    }

    /**
     * Define o assunto do processo
     * @param string $assunto
     */
    public function setAssunto($assunto)
    {
        $this->setAttribute('assunto', $assunto);
        return $this;
    }

    /**
     * Define os fatos do processo
     * @param string $fatos
     */
    public function setFatos($fatos)
    {
        $this->setAttribute('fatos', $fatos);
        return $this;
    }

    /**
     * Define os pedidos do processo
     * @param string $pedidos
     */
    public function setPedidos($pedidos)
    {
        $this->setAttribute('pedidos', $pedidos);
        return $this;
    }

    /**
     * Define o valor do processo
     * @param double $valor
     */
    public function setValor($valor)
    {
        $this->setAttribute('valor', $valor);
        return $this;
    }

    public function getTestemunas()
    {
        return Testemunha::findByProcesso($this);
    }

    public function getResumo(): array
    {
        return ArrayHelper::toArray(
            $this,
            [
                self::className() => [
                    'id' => self::newDefaultGetterClosure('getId'),
                    'numero' => self::newDefaultGetterClosure('getNumero'),
                    'assunto' => self::newDefaultGetterClosure('getAssunto'),
                    'distribuicao' => self::newDefaultGetterClosure('getDistribuicao'),
                    'juiz' => self::newDefaultGetterClosure('getJuiz')
                ]
            ],
            true
        );
    }
}
