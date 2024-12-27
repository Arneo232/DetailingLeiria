<?php

use common\models\Venda;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Vendas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venda-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Venda', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idVenda',
            'total',
            'datavenda',
            'metodoPagamento_id',
            'metodoEntrega_id',
            //'idCarrinhoFK',
            //'idProfileFK',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Venda $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idVenda' => $model->idVenda]);
                 }
            ],
        ],
    ]); ?>


</div>
