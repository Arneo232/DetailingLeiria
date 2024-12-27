<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinho".
 *
 * @property int $idCarrinho
 * @property float|null $total
 * @property string|null $datavenda
 * @property int $idProfile
 * @property int $idMetodoEntrega
 * @property int $idMetodoPagamento
 *
 * @property Metodoentrega $idMetodoEntrega0
 * @property Metodopagamento $idMetodoPagamento0
 * @property Profile $idProfile0
 * @property Linhascarrinho[] $linhascarrinhos
 */
class Carrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total'], 'number'],
            [['datavenda'], 'safe'],
            [['idProfile'], 'required'],
            [['idProfile', 'idMetodoEntrega', 'idMetodoPagamento'], 'integer'],
            [['idMetodoEntrega'], 'exist', 'skipOnError' => true, 'targetClass' => Metodoentrega::class, 'targetAttribute' => ['idMetodoEntrega' => 'idmetodoEntrega']],
            [['idMetodoPagamento'], 'exist', 'skipOnError' => true, 'targetClass' => Metodopagamento::class, 'targetAttribute' => ['idMetodoPagamento' => 'idMetodoPagamento']],
            [['idProfile'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['idProfile' => 'idprofile']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idCarrinho' => 'Id Carrinho',
            'total' => 'Total',
            'datavenda' => 'Datavenda',
            'idProfile' => 'Id Profile',
            'idMetodoEntrega' => 'Id Metodo Entrega',
            'idMetodoPagamento' => 'Id Metodo Pagamento',
        ];
    }

    /**
     * Gets query for [[IdMetodoEntrega]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodoEntrega()
    {
        return $this->hasOne(Metodoentrega::class, ['idMetodoEntrega' => 'idMetodoEntrega']);
    }

    /**
     * Gets query for [[IdMetodoPagamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodoPagamento()
    {
        return $this->hasOne(Metodopagamento::class, ['idMetodoPagamento' => 'idMetodoPagamento']);
    }

    /**
     * Gets query for [[IdProfile0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['idprofile' => 'idProfile']);
    }

    /**
     * Gets query for [[Linhascarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhascarrinho()
    {
        return $this->hasMany(Linhascarrinho::class, ['carrinho_id' => 'idCarrinho']);
    }
    public function getVenda()
    {
        return $this->hasOne(Venda::class, ['idVenda' => 'idVendaFK']);
    }
}
