<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "venda".
 *
 * @property int $idvenda
 * @property float|null $total
 * @property string|null $datavenda
 * @property int $metodoPagamento_id
 * @property int $metodoEntrega_id
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
}
