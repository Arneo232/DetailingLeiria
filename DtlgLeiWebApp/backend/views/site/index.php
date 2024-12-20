<?php
$this->title = 'Painel de Administração';
$this->params['breadcrumbs'] = [['label' => $this->title]];

use common\models\User;
$numUsers = User::find()->count(); // Conta o número de utilizadores

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="d-flex align-items-center mb-4">
                <!-- Ícone de segurança -->
                <i class="fas fa-shield-alt" style="font-size: 3rem; color: rgba(0,164,224,0.94); margin-right: 15px;"></i>
                <!-- Título -->
                <div>
                    <h1 style="margin: 0; font-size: 1.8rem; color: rgba(0,164,224,0.94);">Área Restrita</h1>
                    <p style="margin: 0; font-size: 1rem; color: #6c757d;">Acesso exclusivo para utilizadores autorizados.</p>
                </div>
            </div>
            <!-- Mensagem de boas-vindas -->
            <?= \hail812\adminlte\widgets\Alert::widget([
                'type' => 'success',
                'body' => '<h5>Bem-vindo, ' . Yii::$app->user->identity->username .
                    '!</h5><p>Obrigado por fazer parte da nossa equipa. Explore as ferramentas disponíveis nesta secção para otimizar o trabalho.</p>',
            ]) ?>
            <!-- Mensagem de destaque -->
            <?= \hail812\adminlte\widgets\Callout::widget([
                'type' => 'info',
                'head' => 'Dica Importante!',
                'body' => 'Certifique-se de que todas as ações estão de acordo com os procedimentos internos da organização.',
            ]) ?>
        </div>
    </div>
</div>


    <div class="col-12 col-sm-6 col-md-3">
        <?= \hail812\adminlte\widgets\InfoBox::widget([
            'text' => 'Utilizadores Registados',
            'number' => $numUsers, // Mostra os utilizadores registados
            'icon' => 'fas fa-users',
        ]) ?>
    </div>


<!--    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?php /*= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Messages',
                'number' => '1,410',
                'icon' => 'far fa-envelope',
            ]) */?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?php /*= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Bookmarks',
                'number' => '410',
                 'theme' => 'success',
                'icon' => 'far fa-flag',
            ]) */?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?php /*= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Uploads',
                'number' => '13,648',
                'theme' => 'gradient-warning',
                'icon' => 'far fa-copy',
            ]) */?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <?php /*= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Bookmarks',
                'number' => '41,410',
                'icon' => 'far fa-bookmark',
                'progress' => [
                    'width' => '70%',
                    'description' => '70% Increase in 30 Days'
                ]
            ]) */?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?php /*$infoBox = \hail812\adminlte\widgets\InfoBox::begin([
                'text' => 'Likes',
                'number' => '41,410',
                'theme' => 'success',
                'icon' => 'far fa-thumbs-up',
                'progress' => [
                    'width' => '70%',
                    'description' => '70% Increase in 30 Days'
                ]
            ]) */?>
            <?php /*= \hail812\adminlte\widgets\Ribbon::widget([
                'id' => $infoBox->id.'-ribbon',
                'text' => 'Ribbon',
            ]) */?>
            <?php /*\hail812\adminlte\widgets\InfoBox::end() */?>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <?php /*= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Events',
                'number' => '41,410',
                'theme' => 'gradient-warning',
                'icon' => 'far fa-calendar-alt',
                'progress' => [
                    'width' => '70%',
                    'description' => '70% Increase in 30 Days'
                ],
                'loadingStyle' => true
            ]) */?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?php /*= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => '150',
                'text' => 'New Orders',
                'icon' => 'fas fa-shopping-cart',
            ]) */?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?php /*$smallBox = \hail812\adminlte\widgets\SmallBox::begin([
                'title' => '150',
                'text' => 'New Orders',
                'icon' => 'fas fa-shopping-cart',
                'theme' => 'success'
            ]) */?>
            <?php /*= \hail812\adminlte\widgets\Ribbon::widget([
                'id' => $smallBox->id.'-ribbon',
                'text' => 'Ribbon',
                'theme' => 'warning',
                'size' => 'lg',
                'textSize' => 'lg'
            ]) */?>
            <?php /*\hail812\adminlte\widgets\SmallBox::end() */?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?php /*= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => '44',
                'text' => 'User Registrations',
                'icon' => 'fas fa-user-plus',
                'theme' => 'gradient-success',
                'loadingStyle' => true
            ]) */?>
        </div>
    </div>-->

</div>