<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

//   $form->field($model, 'password')->passwordInput(['maxlength' => true])
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'form-signup', 'enableClientValidation' => true]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'role')->dropDownList(
        \yii\helpers\ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name'),
        ['prompt' => 'Selecione a Role']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
