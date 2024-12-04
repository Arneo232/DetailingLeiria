<?php

use common\models\Metodopagamento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MetodopagamentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Metodopagamentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodopagamento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Metodopagamento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idMetodoPagamento',
            'designacao',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Metodopagamento $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idMetodoPagamento' => $model->idMetodoPagamento]);
                 }
            ],
        ],
    ]); ?>


</div>
