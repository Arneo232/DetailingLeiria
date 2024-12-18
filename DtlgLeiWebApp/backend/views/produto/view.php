<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */

$this->title = $model->idProduto;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idProduto' => $model->idProduto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idProduto' => $model->idProduto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idProduto',
            'nome',
            'descricao',
            'preco',
            'stock',
            [
                'label' => 'Categoria',
                'value' => function ($model) {
                    return $model->categoria ? $model->categoria->designacao : 'No Category selected';
                },
            ],
            [
                'label' => 'Fornecedor',
                'value' => function ($model) {
                    return $model->fornecedor ? $model->fornecedor->nome : 'No Category selected';
                },
            ],
            [
                'label' => 'Desconto',
                'value' => function ($model) {
                    return $model->desconto ? $model->desconto->desconto : '(No Discount selected)';
                },
            ],
            [
                'attribute' => 'imagemID',
                'label' => 'Imagem',
                'value' => $imagem->fileName,
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],

        ],
    ]) ?>

</div>
