<?php

namespace common\models;

use Yii;
use yii\debug\models\search\Profile;

/**
 * This is the model class for table "venda".
 *
 * @property int $idvenda
 * @property float|null $total
 * @property string|null $datavenda
 * @property int $metodoPagamento_id
 * @property int $metodoEntrega_id
 * @property bool|null $estado_encomenda
 *
 * @property Linhasvenda[] $linhasvendas
 * @property Metodoentrega $metodoEntrega
 * @property Metodopagamento $metodoPagamento
 */
class Venda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'venda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total'], 'number'],
            [['datavenda'], 'safe'],
            [['metodoPagamento_id', 'metodoEntrega_id'], 'required'],
            [['metodoPagamento_id', 'metodoEntrega_id'], 'integer'],
            [['estado_encomenda'], 'boolean'],
            [['metodoEntrega_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metodoentrega::class, 'targetAttribute' => ['metodoEntrega_id' => 'idmetodoEntrega']],
            [['metodoPagamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metodopagamento::class, 'targetAttribute' => ['metodoPagamento_id' => 'idMetodoPagamento']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idvenda' => 'Idvenda',
            'total' => 'Total',
            'datavenda' => 'Datavenda',
            'metodoPagamento_id' => 'Metodo Pagamento ID',
            'metodoEntrega_id' => 'Metodo Entrega ID',
            'estado_encomenda' => 'Estado Encomenda',
        ];
    }

    /**
     * Gets query for [[Linhasvendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasVenda()
    {
        return $this->hasMany(Linhasvenda::class, ['idVendaFK' => 'idVenda']);
    }

    /**
     * Gets query for [[MetodoEntrega]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodoEntrega()
    {
        return $this->hasOne(Metodoentrega::class, ['idmetodoEntrega' => 'metodoEntrega_id']);
    }

    /**
     * Gets query for [[MetodoPagamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodoPagamento()
    {
        return $this->hasOne(Metodopagamento::class, ['idMetodoPagamento' => 'metodoPagamento_id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['idprofile' => 'idProfileFK']);
    }

    // Messaging das Vendas
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $idVenda = $this->idVenda;
        $total = $this->total;
        $datavenda = $this->datavenda;

        $mensagemCriacao = "Foi feito uma venda (ID: {$idVenda}) no total de {$total} euros.";

        $this->FazPublishNoMosquitto("INSERT_VENDA", $mensagemCriacao);
    }

    public function FazPublishNoMosquitto($canal, $msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $username = ""; // Coloque o username, se necessário
        $password = ""; // Coloque a password, se necessário
        $client_id = "phpMQTT-publisher-venda"; // Deve ser único para evitar colisões

        $mqtt = new \common\mosquitto\phpMQTT($server, $port, $client_id);

        if ($mqtt->connect(true, NULL, $username, $password)) {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        } else {
            file_put_contents('debug.output', 'MQTT Timeout!');
        }
    }
}
