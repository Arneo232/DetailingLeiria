<?php
use yii\helpers\Html;
?>

<header>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/site.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</header>

<div class="dl-login-section">
    <div class="dl-login-card">
        <div class="dl-logo-container">
            <img src="<?= Yii::getAlias('@web') ?>/images/Logo_Solo.png" alt="Logo do DL" class="dl-login-logo">
        </div>
        <h1 class="dl-login-title">Log In</h1>
        <p class="dl-login-description">Sign in to start your session</p>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php elseif (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>

        <div class="dl-login-container">
            <?= $form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('username'), 'class' => 'dl-login-input']) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'class' => 'dl-login-input']) ?>

            <div class="dl-login-rememberme">
                <?= $form->field($model, 'rememberMe')->checkbox([ 'template' => '<div class="icheck-primary">{input}{label}</div>', 'labelOptions' => ['class' => ''], 'uncheck' => null]) ?>
            </div>

            <div class="dl-login-button-container">
                <?= Html::submitButton('Sign In', ['class' => 'dl-login-button']) ?>
            </div>
        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>


        <p class="mb-1">
            <a href="forgot-password.html">I forgot my password</a>
        </p>
        <p class="mb-0">
            <a href="register.html" class="text-center">Register a new membership</a>
        </p>
    </div>
</div>
