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
 * @property int $idLinhasCarrinhoFK
 *
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
            [['quantidade', 'idVendaFK', 'idProdutoFK'], 'integer'],
            [['precounitario', 'subtotal'], 'number'],
            [['idVendaFK', 'idProdutoFK'], 'required'],
            [['idProdutoFK'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['idProdutoFK' => 'idProduto']],
            [['idVendaFK'], 'exist', 'skipOnError' => true, 'targetClass' => Venda::class, 'targetAttribute' => ['idVendaFK' => 'idVenda']],
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
            'precounitario' => 'Preço Unitário',
            'subtotal' => 'Subtotal',
            'idVendaFK' => 'Id Venda Fk',
            'idProdutoFK' => 'Id Produto Fk',
        ];
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
