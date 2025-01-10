<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Tarefa $model */

$this->title = $model->idTarefa;
$this->params['breadcrumbs'][] = ['label' => 'Tarefas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tarefa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idTarefa' => $model->idTarefa], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idTarefa' => $model->idTarefa], [
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
            'idTarefa',
            'descricao',
            'feito',
            'idProfileFK',
        ],
    ]) ?>

</div>
