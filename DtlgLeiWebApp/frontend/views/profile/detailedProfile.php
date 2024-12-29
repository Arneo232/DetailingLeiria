<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\assets\AppAsset;

$this->title = 'DL | Perfil';
$this->params['breadcrumbs'][] = $this->title;

?>
<header>
    <!-- Link para o arquivo de CSS (styledata.css) -->
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/styledata.css">
</header>
<div class="user-view container">
    <div class="profile-header text-center">
        <!-- Logo -->
        <div class="profile-logo">
            <?= Html::img(Yii::getAlias('@web') . '/images/logo.png', ['alt' => 'Logo', 'class' => 'img-fluid profile-logo-img']) ?>
        </div>

        <!-- Título -->
        <h2 class="profile-title"><?= 'Perfil de ' . Html::encode($model->username); ?></h2>
        <p class="profile-subtitle">Gerencie suas informações pessoais</p>
    </div>

    <div class="profile-details mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4><i class="fas fa-user"></i> Informações Pessoais</h4>
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'id',
                                'username',
                                'email:email',
                                [
                                    'label' => 'Telefone',
                                    'value' => function ($model) {
                                        return $model->profile ? $model->profile->ntelefone : '(não definido)';
                                    },
                                ],
                                [
                                    'label' => 'Morada',
                                    'value' => function ($model) {
                                        return $model->profile ? $model->profile->morada : '(não definida)';
                                    },
                                ],
                            ],
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <h4><i class="fas fa-cogs"></i> Ações Rápidas</h4>
                        <p>
                            <?= Html::a('<i class="fas fa-edit"></i> Editar Perfil', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-block']) ?>
                        </p>
                        <p>
                            <?php
                            echo Html::a('<i class="fas fa-sign-out-alt"></i> Sair', ['site/logout'], [
                                'class' => 'btn btn-danger btn-block',
                                'data' => [
                                    'method' => 'post',
                                ]
                            ]);
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
