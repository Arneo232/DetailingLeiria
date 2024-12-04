<?php

namespace common\models;

use app\models\Venda;


/**
 * This is the model class for table "metodopagamento".
 *
 * @property int $idMetodoPagamento
 * @property string|null $designacao
 *
 * @property Venda[] $vendas
 */
class Metodopagamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metodopagamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['designacao'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idMetodoPagamento' => 'Id Metodo Pagamento',
            'designacao' => 'Designacao',
        ];
    }

    /**
     * Gets query for [[Vendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendas()
    {
        return $this->hasMany(Venda::class, ['metodoPagamento_id' => 'idMetodoPagamento']);
    }
}
