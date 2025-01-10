<?php

use common\models\Tarefa;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\TarefaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tarefas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarefa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tarefa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idTarefa',
            'descricao',
            'feito',
            'idProfileFK',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Tarefa $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idTarefa' => $model->idTarefa]);
                 }
            ],
        ],
    ]); ?>


</div>
