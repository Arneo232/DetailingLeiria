<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'DL | Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<header>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/styledata.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</header>

<div class="dl-login-section">
    <div class="dl-login-card">
        <div class="dl-logo-container">
            <img src="<?= Yii::getAlias('@web') ?>/images/Logo_Solo.png" alt="Logo do DL" class="dl-login-logo">
        </div>
        <h1 class="dl-login-title">Login</h1>
        <p class="dl-login-description">Acesse a sua conta para descobrir uma experiência única!</p>

        <div class="dl-login-container">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'dl-login-input']) ?>

            <?= $form->field($model, 'password')->passwordInput(['class' => 'dl-login-input']) ?>

            <div class="dl-login-rememberme">
                <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'dl-login-checkbox'])->label(false) ?>
                <label class="dl-login-checkbox-label">Remember Me</label>
            </div>

            <div class="dl-login-links">
                Esqueceu a sua palavra-passe? <?= Html::a('Redefinir', ['site/request-password-reset'], ['class' => 'dl-login-link']) ?>.
                <br>
                Novo por aqui? <?= Html::a('Registe-se', ['site/signup'], ['class' => 'dl-login-link']) ?>
            </div>

            <div class="dl-login-button-container">
                <?= Html::submitButton('Entrar', ['class' => 'dl-login-button', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<hr>
