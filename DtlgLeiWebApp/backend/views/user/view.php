<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tarefa', ['tarefa', 'id' => $model->tarefa->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'username',
            'email:email',
            'role',
            [
                'label' => 'Telefone',
                'value' => function ($model) {
                    return $model->profile ? $model->profile->ntelefone : '(not set)';
                },
            ],
            [
                'label' => 'Morada',
                'value' => function ($model) {
                    return $model->profile ? $model->profile->morada : '(not set)';
                },
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
