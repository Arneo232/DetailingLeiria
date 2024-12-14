<?php

namespace common\models;

use common\models\Produto;

/**
 * This is the model class for table "imagem".
 *
 * @property int $idimagem
 * @property string|null $fileName
 * @property int $produtoId
 *
 * @property Produto $produto
 */
class Imagem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produtoId'], 'required'],
            [['produtoId'], 'integer'],
            [['fileName'], 'string', 'max' => 45],
            [['produtoId'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produtoId' => 'idProduto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idimagem' => 'Idimagem',
            'fileName' => 'File Name',
            'produtoId' => 'Produto ID',
        ];
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['idProduto' => 'produtoId']);
    }
}
