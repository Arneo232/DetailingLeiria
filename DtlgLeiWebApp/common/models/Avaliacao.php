<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "avaliacao".
 *
 * @property int $idavaliacao
 * @property string|null $comentario
 * @property float $rating
 * @property int $idProdutoFK
 * * @property int $idProfileFK
 *
 * @property Produto $produto
 * * @property Profile $profile
 */
class Avaliacao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avaliacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rating', 'idProdutoFK', 'idProfileFK'], 'required'],
            [['rating'], 'in', 'range' => [1, 2, 3, 4, 5]],
            [['rating'], 'number'],
            [['idProdutoFK', 'idProfileFK'], 'integer'],
            [['comentario'], 'string', 'max' => 256],
            [['idProdutoFK'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['idProdutoFK' => 'idProduto']],
            [['idProfileFK'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['idProfileFK' => 'idprofile']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idavaliacao' => 'Id Avaliação',
            'comentario' => 'Comentário',
            'rating' => 'Nota',
            'idProdutoFK' => 'ID Produto',
            'idProfileFK' => 'ID Profile',
        ];
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['idProduto' => 'idProdutoFK']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['idprofile' => 'idProfileFK']);
    }
}

