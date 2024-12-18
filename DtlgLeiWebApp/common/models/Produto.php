<?php

namespace common\models;

use common\models\Categoria;
use common\models\Favorito;
use common\models\Fornecedor;
use common\models\Linhascarrinho;
use common\models\Linhasvenda;

/**
 * This is the model class for table "produto".
 *
 * @property int $idProduto
 * @property string|null $nome
 * @property string|null $descricao
 * @property float|null $preco
 * @property int|null $stock
 * @property int $idCategoria
 * @property int $fornecedores_idfornecedores
 * @property int $idDesconto
 *
 * @property Favorito[] $favoritos
 * @property Fornecedor $fornecedoresIdfornecedores
 * @property Categoria $idCategoria0
 * @property Imagem[] $imagems
 * @property Linhascarrinho[] $linhascarrinhos
 * @property Linhasvenda[] $linhasvendas
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preco'], 'number'],
            [['stock', 'idCategoria', 'fornecedores_idfornecedores'], 'integer'],
            [['idCategoria', 'fornecedores_idfornecedores'], 'required'],
            [['nome', 'descricao'], 'string', 'max' => 45],
            [['idCategoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['idCategoria' => 'idCategoria']],
            [['fornecedores_idfornecedores'], 'exist', 'skipOnError' => true, 'targetClass' => Fornecedor::class, 'targetAttribute' => ['fornecedores_idfornecedores' => 'idfornecedor']],
            [['idDesconto'], 'exist', 'skipOnError' => true, 'targetClass' => Desconto::class, 'targetAttribute' => ['idDesconto' => 'iddesconto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idProduto' => 'Id do Produto',
            'nome' => 'Nome',
            'descricao' => 'Descricao',
            'preco' => 'Preco',
            'stock' => 'Stock',
            'idCategoria' => 'Categoria',
            'fornecedores_idfornecedores' => 'Fornecedor',
            'idDesconto' => 'Desconto',
        ];
    }

    public function addDescontoPreco($preco, $idDesconto){
        $desconto = Desconto::findOne($idDesconto);
        $preco = ($preco - ($preco * ($desconto->desconto / 100)));
        return $preco;
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            $this->preco = $this->addDescontoPreco($this->preco, $this->idDesconto);
            return true;
        }
        return false;
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favorito::class, ['produto_id' => 'idProduto']);
    }

    /**
     * Gets query for [[FornecedoresIdfornecedores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedor()
    {
        return $this->hasOne(Fornecedor::class, ['idfornecedor' => 'fornecedores_idfornecedores']);
    }

    /**
     * Gets query for [[IdCategoria0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['idCategoria' => 'idCategoria']);
    }

    /**
     * Gets query for [[Imagems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagem()
    {
        return $this->hasMany(Imagem::class, ['produtoId' => 'idProduto']);
    }

    public function getDesconto()
    {
        return $this->hasOne(Desconto::class, ['iddesconto' => 'idDesconto']);
    }


    /**
     * Gets query for [[Linhascarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhascarrinhos()
    {
        return $this->hasMany(Linhascarrinho::class, ['produtos_id' => 'idProduto']);
    }

    /**
     * Gets query for [[Linhasvendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasvendas()
    {
        return $this->hasMany(Linhasvenda::class, ['produtos_idProduto' => 'idProduto']);
    }
}
