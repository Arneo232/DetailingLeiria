<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "profile".
 *
 * @property int $idprofile
 * @property string|null $morada
 * @property int|null $ntelefone
 *
 * @property Favorito[] $favoritos
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ntelefone'], 'integer'],
            [['morada'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idprofile' => 'Idprofile',
            'morada' => 'Morada',
            'ntelefone' => 'Ntelefone',
        ];
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favorito::class, ['profile_id' => 'idprofile']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }
}
