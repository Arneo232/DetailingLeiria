<?php

use common\models\Desconto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\DescontoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Descontos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="desconto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Desconto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'iddesconto',
            'desconto',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Desconto $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'iddesconto' => $model->iddesconto]);
                 }
            ],
        ],
    ]); ?>


</div>
