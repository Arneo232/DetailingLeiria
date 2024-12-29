<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\VendaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="venda-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idVenda') ?>

    <?= $form->field($model, 'total') ?>

    <?= $form->field($model, 'datavenda') ?>

    <?= $form->field($model, 'metodoPagamento_id') ?>

    <?= $form->field($model, 'metodoEntrega_id') ?>

    <?php // echo $form->field($model, 'idCarrinhoFK') ?>

    <?php // echo $form->field($model, 'idProfileFK') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
