<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var backend\models\VendaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Vendas Feitas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venda-feito">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="navigation-buttons">
        <?= Html::a('Encomendas Não Entregues', ['venda/nao-entregue'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Encomendas Entregues', ['venda/entregue'], ['class' => 'btn btn-success']) ?>
    </div>

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
            [
                'attribute' => 'estado_encomenda',
                'label' => 'Estado Encomenda',
                'format' => 'raw',
                'value' => function ($model) {
                    $label = $model->estado_encomenda ? 'Entregue' : 'Não Entregue';
                    $btnClass = $model->estado_encomenda ? 'btn-success' : 'btn-danger';
                    return Html::a(
                        $label,
                        ['venda/toggle-estado-encomenda', 'idVenda' => $model->idVenda],
                        [
                            'class' => "btn $btnClass btn-sm",
                            'data-method' => 'post',
                            'data-confirm' => 'Tem a certeza que quer alterar o estado da encomenda?',
                        ]
                    );
                },
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::toRoute([$action, 'idVenda' => $model->idVenda]);
                },
            ],
        ],
    ]); ?>
</div>
