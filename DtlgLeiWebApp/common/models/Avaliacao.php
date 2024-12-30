<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "avaliacao".
 *
 * @property int $idavaliacao
 * @property string|null $comentario
 * @property float $rating
 * @property int $idLinhasVendaFK
 *
 * @property Linhasvenda $linhasVenda
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
            [['rating', 'idLinhasVendaFK'], 'required'],
            [['rating'], 'number'],
            [['idLinhasVendaFK'], 'integer'],
            [['comentario'], 'string', 'max' => 256],
            [['idLinhasVendaFK'], 'unique'],
            [['idLinhasVendaFK'], 'exist', 'skipOnError' => true, 'targetClass' => Linhasvenda::class, 'targetAttribute' => ['idLinhasVendaFK' => 'idLinhasVenda']],
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
            'idLinhasVendaFK' => 'Id Linha de Venda',
        ];
    }

    /**
     * Gets query for [[LinhasVenda]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasVenda()
    {
        return $this->hasOne(Linhasvenda::class, ['idLinhasVenda' => 'idLinhasVendaFK']);
    }
}

