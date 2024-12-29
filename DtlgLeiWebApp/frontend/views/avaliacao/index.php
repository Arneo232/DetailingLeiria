<?php

use common\models\avaliacao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\AvaliacaoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Avaliacaos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="avaliacao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Avaliacao', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idavaliacao',
            'comentario',
            'rating',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, avaliacao $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idavaliacao' => $model->idavaliacao]);
                 }
            ],
        ],
    ]); ?>


</div>
