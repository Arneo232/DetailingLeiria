<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\TarefaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tarefa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idTarefa') ?>

    <?= $form->field($model, 'descricao') ?>

    <?= $form->field($model, 'feito') ?>

    <?= $form->field($model, 'idProfileFK') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
