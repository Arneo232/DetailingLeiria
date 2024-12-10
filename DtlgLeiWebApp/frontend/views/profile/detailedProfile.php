<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\widgets\DetailView;

$this->title = 'DL | Profile';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-view">

    <h2>Perfil de <?= $model->username; ?></h2>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
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
        ],
    ]) ?>

</div>