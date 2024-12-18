<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "desconto".
 *
 * @property int $iddesconto
 * @property int $desconto
 *
 * @property Produto[] $produtos
 */
class Desconto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'desconto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desconto'], 'required'],
            [['desconto'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iddesconto' => 'Iddesconto',
            'desconto' => 'Desconto',
        ];
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['idDesconto' => 'iddesconto']);
    }
}
