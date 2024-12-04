<?php

namespace common\models;

use app\models\Produto;

/**
 * This is the model class for table "categoria".
 *
 * @property int $idCategoria
 * @property string|null $designacao
 * @property int $idCategoriaPai
 *
 * @property Categoria[] $categorias
 * @property Categoria $idCategoriaPai0
 * @property Produto[] $produtos
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idCategoriaPai'], 'required'],
            [['idCategoriaPai'], 'integer'],
            [['designacao'], 'string', 'max' => 45],
            [['idCategoriaPai'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['idCategoriaPai' => 'idCategoria']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idCategoria' => 'Id Categoria',
            'designacao' => 'Designacao',
            'idCategoriaPai' => 'Id Categoria Pai',
        ];
    }

    /**
     * Gets query for [[Categorias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categoria::class, ['idCategoriaPai' => 'idCategoria']);
    }

    /**
     * Gets query for [[IdCategoriaPai0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoriaPai0()
    {
        return $this->hasOne(Categoria::class, ['idCategoria' => 'idCategoriaPai']);
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['idCategoria' => 'idCategoria']);
    }
}
