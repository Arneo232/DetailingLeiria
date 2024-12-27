<?php

namespace common\models;

use common\models\Venda;
use common\models\Carrinho;

/**
 * This is the model class for table "metodoentrega".
 *
 * @property int $idmetodoEntrega
 * @property string|null $designacao
 *
 * @property Venda[] $vendas
 */
class Metodoentrega extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metodoentrega';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['designacao'], 'string', 'max' => 75],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idmetodoEntrega' => 'Idmetodo Entrega',
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
        return $this->hasMany(Venda::class, ['metodoEntrega_id' => 'idmetodoEntrega']);
    }

    public function getCarrinho(){
        return $this->HasMany(Carrinho::class, ['idMetodoEntrega' => 'idmetodoEntrega']);
    }
}
