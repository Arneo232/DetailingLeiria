<?php

namespace common\models;

use common\models\Produto;

/**
 * This is the model class for table "fornecedor".
 *
 * @property int $idfornecedor
 * @property string|null $nome
 *
 * @property Produto[] $produtos
 */
class Fornecedor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fornecedor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idfornecedor' => 'Idfornecedor',
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['fornecedores_idfornecedores' => 'idfornecedor']);
    }
}
