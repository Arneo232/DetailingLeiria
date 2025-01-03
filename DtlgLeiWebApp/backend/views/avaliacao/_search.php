<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\AvaliacaoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="avaliacao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idavaliacao') ?>

    <?= $form->field($model, 'comentario') ?>

    <?= $form->field($model, 'rating') ?>

    <?= $form->field($model, 'idProfileFK') ?>

    <?= $form->field($model, 'idProdutoFK') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
