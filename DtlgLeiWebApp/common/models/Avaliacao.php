<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "avaliacao".
 *
 * @property int $idavaliacao
 * @property string|null $comentario
 * @property float $rating
 *
 * @property Linhasvenda[] $linhasvendas
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
            [['rating'], 'required'],
            [['rating'], 'number'],
            [['comentario'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idavaliacao' => 'Idavaliacao',
            'comentario' => 'Comentario',
            'rating' => 'Rating',
        ];
    }

    /**
     * Gets query for [[Linhasvendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasvendas()
    {
        return $this->hasMany(Linhasvenda::class, ['idAvaliacaoFK' => 'idavaliacao']);
    }
}
