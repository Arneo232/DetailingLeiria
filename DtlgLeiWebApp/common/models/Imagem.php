<?php

namespace common\models;

use common\models\Produto;
use Yii;

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

    public function deleteImage(){
        // Specify the absolute path to the uploads directory
        $uploadsDirectory = dirname(dirname(__DIR__)) . '/frontend/web/uploads/';

        // Build the full file path for the image
        $filePath = $uploadsDirectory . $this->fileName;

        // Check if the file exists and delete it
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file
        }

        // Delete the database record for the image
        return $this->delete();
    }
}
