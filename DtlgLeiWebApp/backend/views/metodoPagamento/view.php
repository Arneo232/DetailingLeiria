<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Metodopagamento $model */

$this->title = $model->idMetodoPagamento;
$this->params['breadcrumbs'][] = ['label' => 'Metodopagamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="metodopagamento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idMetodoPagamento' => $model->idMetodoPagamento], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idMetodoPagamento' => $model->idMetodoPagamento], [
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
            'idMetodoPagamento',
            'designacao',
        ],
    ]) ?>

</div>
