<?php

use common\models\Carrinho;
use common\models\Metodopagamento;
use common\models\Metodoentrega;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Carrinhos';
$this->params['breadcrumbs'][] = $this->title;

// Fetch the user's cart
$carrinho = Carrinho::find()->where(['idProfile' => Yii::$app->user->identity->profile->idprofile])->one();
?>

<header>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/styledata.css">
</header>

<div class="container">
    <h1 class="text-center my-4 font-weight-bold">Checkout</h1>

    <!-- Botão para voltar ao Carrinho -->
    <div class="text-center mb-4">
        <?= Html::a('Voltar ao Carrinho', ['carrinho/index'], ['class' => 'btn btn-secondary']) ?>
    </div>
    <hr class="dl-divider">
    <?= Html::beginForm(['venda/finalizar-compra'], 'post') ?>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Método de Entrega</h5>
                        <div class="form-group">
                            <?= Html::dropDownList('idMetodoEntrega', $carrinho->idMetodoEntrega, $metodoEntrega, [
                                'class' => 'form-control',
                                'prompt' => 'Selecione um método'
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Método de Pagamento</h5>
                        <div class="form-group">
                            <?= Html::dropDownList('idMetodoPagamento', $carrinho->idMetodoPagamento, $metodoPagamento, [
                                'class' => 'form-control',
                                'prompt' => 'Selecione um método'
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="dl-divider">

        <!-- Botão de Finalizar Compra -->
        <div class="text-center">
            <?= Html::beginForm(['venda/finalizar-compra'], 'post') ?>
            <!-- Add your form fields for payment and delivery method -->
            <?= Html::submitButton('Finalizar Compra', ['class' => 'btn btn-success']) ?>
            <?= Html::endForm() ?>
        </div>
    <?= Html::endForm() ?>
</div>
