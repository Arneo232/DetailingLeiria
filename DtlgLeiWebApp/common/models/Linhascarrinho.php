<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhascarrinho".
 *
 * @property int $idLinhasCarrinho
 * @property int|null $quantidade
 * @property float|null $precounitario
 * @property float|null $subtotal
 * @property int $carrinho_id
 * @property int $produtos_id
 *
 * @property Carrinho $carrinho
 * @property Produto $produtos
 */
class Linhascarrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhascarrinho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'carrinho_id', 'produtos_id'], 'integer'],
            [['precounitario', 'subtotal'], 'number'],
            [['carrinho_id', 'produtos_id'], 'required'],
            [['produtos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produtos_id' => 'idProduto']],
            [['carrinho_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinho::class, 'targetAttribute' => ['carrinho_id' => 'idCarrinho']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idLinhasCarrinho' => 'Id Linhas Carrinho',
            'quantidade' => 'Quantidade',
            'precounitario' => 'Precounitario',
            'subtotal' => 'Subtotal',
            'carrinho_id' => 'Carrinho ID',
            'produtos_id' => 'Produtos ID',
        ];
    }

    /**
     * Gets query for [[Carrinho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinho()
    {
        return $this->hasOne(Carrinho::class, ['idCarrinho' => 'carrinho_id']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['idProduto' => 'produtos_id']);
    }
}
