<?php

namespace app\models;

use app\models\AbstractModel;
use app\models\Endereco;
use app\models\Magistrado;

class Vara extends AbstractModel {

    /**
     * Retorna o nome da tabela
     * @return string
     */
    public static function tableName()
    { return 'vara'; }

    /**
     * Retorna a ID da vara
     * @return integer
     */
    public function getId()
    { return $this->getAttribute('id'); }

    /**
     * Retorna o nome da vara
     * @return string
     */
    public function getNome()
    { return $this->getAttribute('nome'); }

    /**
     * Retorna o endereço da vara
     * @return Endereco
     */
    public function getEndereco()
    { return $this->hasOne(Endereco::className(), ['id' => 'endereco'])->one(); }

    /**
     * Retorna o ID do último juiz sorteado da vara
     * @return int
     */
    public function getUltimoSorteado()
    { return $this->getAttribute('ultimo_sorteado'); }

    /**
     * Retorna a data do último sorteado de processo da vara
     * @return DateTime
     */
    public function getUltimoNumeroDt()
    { return new \DateTime($this->getAttribute('ultimo_numero_dt')); }

    /**
     * Retorna o numero de sequencia do último sorteado de processo da vara
     * @return int
     */
    public function getUltimoNumeroSeq()
    { return $this->getAttribute('ultimo_numero_seq'); }

    /**
     * Define o nome da vara
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->setAttribute('nome', $nome);
        return $this;
    }

    /**
     * Define o endereço da vara
     * @param Endereco $endereco
     */
    public function setEndereco($endereco)
    {
        $this->setAttribute('endereco', $endereco->getId());
        return $this;
    }

    /**
     * Define o ultimo juiz sorteado da vara
     * @param string $juiz
     */
    public function setUltimoSorteado($juiz)
    {
        $this->setAttribute('ultimo_sorteado', $juiz->getId());
        return $this;
    }

    /**
     * Define a data do último sorteado de processo da vara
     * @param DateTime $data
     */
    public function setUltimoNumeroDt($data)
    {
        $this->setAttribute('ultimo_numero_dt', $data->format('Y-m-d'));
        return $this;
    }

    /**
     * Define o numero de sequencia do último sorteado de processo da vara
     * @param int $seq
     */
    public function setUltimoNumeroSeq($seq)
    {
        $this->setAttribute('ultimo_numero_seq', $seq);
        return $this;
    }

    /**
     * Procura o juiz com maior ID imediato
     * @param  int $id     ID de referencia
     * @param  array $juizes Lista de juizes
     * @return Magistrado
     */
    protected static function nextJuizById($id, $juizes)
    {
        //Procura pelo maior ID mais proximo
        foreach ($juizes as $j) if($j->getId() > $id) return $j;
        return null;
    }

    /**
     * Sorteia o proximo juiz para um processo
     * @return Magistrado
     */
    public function sortearJuiz()
    {
        //Busca todos os juizes da vara
        $juizes = Magistrado::findByVara($this);

        //Recupera o ID do ultimo juiz sorteado
        $ultimo = $this->getUltimoSorteado();

        //Pega o proximo juiz pelo ID maior mais proximo
        $escolhido = Self::nextJuizById($ultimo, $juizes);

        //Se encontrou um proximo, retorna
        if($escolhido != null) return $escolhido;

        //Se não encontrou o proximo, tenta novamente a partir do primeiro juiz
        return Self::nextJuizById(0, $juizes);
    }
}
