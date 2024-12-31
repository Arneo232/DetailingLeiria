<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'DL | Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<header>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/styledata.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</header>

<div class="dl-register-section">
    <div class="dl-register-card">
        <div class="dl-logo-container">
            <img src="<?= Yii::getAlias('@web') ?>/images/Logo_Solo.png" alt="Logo do DL" class="dl-register-logo">
        </div>
        <h1 class="dl-register-title">Signup</h1>
        <p class="dl-register-description">Crie sua conta para começar a aproveitar todos os nossos produtos e serviços exclusivos!</p>

        <div class="dl-register-container">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'dl-register-input']) ?>

            <?= $form->field($model, 'email')->textInput(['class' => 'dl-register-input']) ?>

            <?= $form->field($model, 'password')->passwordInput(['class' => 'dl-register-input']) ?>

            <?= $form->field($model, 'ntelefone')->textInput(['class' => 'dl-register-input']) ?>

            <?= $form->field($model, 'morada')->textInput(['class' => 'dl-register-input']) ?>

            <div class="dl-register-button-container">
                <?= Html::submitButton('Registrar', ['class' => 'dl-register-button', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<hr>