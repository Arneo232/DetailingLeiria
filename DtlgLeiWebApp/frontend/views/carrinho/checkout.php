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
<div class="container">
    <h1>Checkout</h1>

    <?= Html::beginForm(['carrinho/finalizar-compra'], 'post') ?>
    <div class="form-group">
        <label for="metodo-entrega">Delivery Method</label>
        <?= Html::dropDownList('idMetodoEntrega', $carrinho->idMetodoEntrega, $metodoEntrega, ['class' => 'form-control', 'prompt' => 'Select a method']) ?>
    </div>
    <div class="form-group">
        <label for="metodo-pagamento">Payment Method</label>
        <?= Html::dropDownList('idMetodoPagamento', $carrinho->idMetodoPagamento, $metodoPagamento, ['class' => 'form-control', 'prompt' => 'Select a method']) ?>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">Finalizar Compra</button>
    </div>
    <?= Html::endForm() ?>
</div>