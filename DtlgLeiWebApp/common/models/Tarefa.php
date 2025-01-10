<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tarefa".
 *
 * @property int $idTarefa
 * @property string $descricao
 * @property int $feito
 * @property int $idProfileFK
 *
 *  * @property Profile $profile
 */
class Tarefa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tarefa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'feito', 'idProfileFK'], 'required'],
            [['feito', 'idProfileFK'], 'integer'],
            [['descricao'], 'string', 'max' => 30],
            [['idProfileFK'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['idProfileFK' => 'idprofile']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idTarefa' => 'Id Tarefa',
            'descricao' => 'Descricao',
            'feito' => 'Feito',
            'idProfileFK' => 'Id Profile',
        ];
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
