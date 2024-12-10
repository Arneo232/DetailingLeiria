<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Atualizar o utilizador: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/profile/_form', [
        'model' => $model,
    ]) ?>

</div>
