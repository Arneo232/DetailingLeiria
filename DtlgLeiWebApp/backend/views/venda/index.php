<?php

use common\models\venda;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\VendaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Vendas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venda-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idVenda',
            'total',
            'datavenda',
            [
                'attribute' => 'metodoPagamento_id',
                'label' => 'Método de Pagamento',
                'value' => function ($model) {
                    return $model->metodoPagamento->designacao ?? 'Não especificado';
                },
            ],
            [
                'attribute' => 'metodoEntrega_id',
                'label' => 'Método de Entrega',
                'value' => function ($model) {
                    return $model->metodoEntrega->designacao ?? 'Não especificado';
                },
            ],
            //'idCarrinhoFK',
            //'idProfileFK',
            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
                'urlCreator' => function ($action, venda $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idVenda' => $model->idVenda]);
                },
            ],
        ],
    ]); ?>


</div>
