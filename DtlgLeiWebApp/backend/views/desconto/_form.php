<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Desconto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="desconto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'desconto')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
