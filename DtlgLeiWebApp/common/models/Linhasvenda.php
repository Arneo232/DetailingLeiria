<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhasvenda".
 *
 * @property int $idLinhasVenda
 * @property int|null $quantidade
 * @property float|null $precounitario
 * @property float|null $subtotal
 * @property int $idVendaFK
 * @property int $idProdutoFK
 * @property int|null $idAvaliacaoFK
 * @property int $idLinhasCarrinhoFK
 *
 * @property Avaliacao $idAvaliacaoFK0
 * @property Linhascarrinho $idLinhasCarrinhoFK0
 * @property Produto $idProdutoFK0
 * @property Venda $idVendaFK0
 */
class Linhasvenda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhasvenda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'idVendaFK', 'idProdutoFK', 'idAvaliacaoFK'], 'integer'],
            [['precounitario', 'subtotal'], 'number'],
            [['idVendaFK', 'idProdutoFK'], 'required'],
            [['idProdutoFK'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['idProdutoFK' => 'idProduto']],
            [['idVendaFK'], 'exist', 'skipOnError' => true, 'targetClass' => Venda::class, 'targetAttribute' => ['idVendaFK' => 'idVenda']],
            [['idAvaliacaoFK'], 'exist', 'skipOnError' => true, 'targetClass' => Avaliacao::class, 'targetAttribute' => ['idAvaliacaoFK' => 'idavaliacao']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idLinhasVenda' => 'Id Linhas Venda',
            'quantidade' => 'Quantidade',
            'precounitario' => 'Precounitario',
            'subtotal' => 'Subtotal',
            'idVendaFK' => 'Id Venda Fk',
            'idProdutoFK' => 'Id Produto Fk',
            'idAvaliacaoFK' => 'Id Avaliacao Fk',
        ];
    }

    /**
     * Gets query for [[IdAvaliacaoFK0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacao()
    {
        return $this->hasOne(Avaliacao::class, ['idavaliacao' => 'idAvaliacaoFK']);
    }

    /**
     * Gets query for [[IdProdutoFK0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['idProduto' => 'idProdutoFK']);
    }

    /**
     * Gets query for [[IdVendaFK0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVenda()
    {
        return $this->hasOne(Venda::class, ['idVenda' => 'idVendaFK']);
    }
}
