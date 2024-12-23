<?php

namespace common\models;

use common\models\Produto;
use common\models\Profile;
use Yii;

/**
 * This is the model class for table "favorito".
 *
 * @property int $produto_id
 * @property int $profile_id
 * @property int $idfavorito
 *
 * @property Produto $produto
 * @property Profile $profile
 */
class Favorito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorito';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produto_id', 'profile_id'], 'required'],
            [['produto_id', 'profile_id'], 'integer'],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'idProduto']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['profile_id' => 'idprofile']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'produto_id' => 'Produto ID',
            'profile_id' => 'Profile ID',
            'idfavorito' => 'Idfavorito',
        ];
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['idProduto' => 'produto_id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['idprofile' => 'profile_id']);
    }
}
