<?php
$this->title = 'Painel de Administração';
$this->params['breadcrumbs'] = [['label' => $this->title]];

use common\models\User;
use miloschuman\highcharts\Highcharts;

// Conta o número de utilizadores
$numUsers = User::find()->count();

// Obtém os dados para o gráfico
$chartData = User::getUsersByDay();
$categories = $chartData['categories']; // Datas no eixo X
$counts = $chartData['counts']; // Número de utilizadores no eixo Y
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

<div class="col-12">
    <!-- Gráfico -->
    <?= Highcharts::widget([
        'options' => [
            'chart' => ['type' => 'line'], // Tipo do gráfico
            'title' => ['text' => 'Registos de Utilizadores por Dia'],
            'xAxis' => [
                'categories' => $categories, // Datas no eixo X
                'title' => ['text' => 'Dias']
            ],
            'yAxis' => [
                'title' => ['text' => 'Número de Utilizadores']
            ],
            'series' => [
                [
                    'name' => 'Utilizadores',
                    'data' => $counts, // Dados do eixo Y
                ],
            ],
        ]
    ]) ?>
</div>
