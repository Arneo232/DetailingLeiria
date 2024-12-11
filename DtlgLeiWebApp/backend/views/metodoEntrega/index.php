<?php

use common\models\Metodoentrega;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\metodoEntregaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Metodoentregas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodoentrega-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Metodoentrega', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idmetodoEntrega',
            'designacao',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Metodoentrega $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idmetodoEntrega' => $model->idmetodoEntrega]);
                 }
            ],
        ],
    ]); ?>


</div>
