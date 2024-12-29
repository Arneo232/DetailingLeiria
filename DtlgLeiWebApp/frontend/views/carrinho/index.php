<?php

use common\models\Carrinho;
use common\models\Linhascarrinho;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'DL | Carrinho';
$this->params['breadcrumbs'][] = $this->title;

// Fetch the user's cart
$carrinho = Carrinho::find()->where(['idProfile' => Yii::$app->user->identity->profile->idprofile])->one();
$linhasCarrinho = $carrinho ? Linhascarrinho::findAll(['carrinho_id' => $carrinho->idCarrinho]) : [];
?>

<header>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/styledata.css">
</header>

<div class="container">
    <h2 class="text-center my-4 font-weight-bold">Carrinho de Compras</h2>

    <!-- Linha para dividir -->
    <hr class="dl-divider">

    <div class="row">
        <?php if (!empty($linhasCarrinho)): ?>
            <?php foreach ($linhasCarrinho as $linha): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-img-top">
                            <?php if (!empty($linha->produto->imagem)): ?>
                                <?= Html::img('../uploads/' . $linha->produto->imagem[0]->fileName, [
                                    'alt' => $linha->produto->nome,
                                    'class' => 'card-img-top',
                                    'style' => 'height: 200px; object-fit: cover;',
                                ]) ?>
                            <?php else: ?>
                                <img src="/images/default-product.png" alt="Produto sem imagem" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= Html::encode($linha->produto->nome) ?></h5>
                            <p class="card-text">Preço: €<?= number_format($linha->precounitario, 2, ',', '.') ?></p>
                            <p class="card-text">Subtotal: €<?= number_format($linha->subtotal, 2, ',', '.') ?></p>

                            <div class="dl-btn-container" style="align-items: center;justify-content: center;">
                                <?= Html::a('-', ['linhas-carrinho/retirar', 'id' => $linha->idLinhasCarrinho], [
                                    'class' => 'btn btn-warning btn-sm',
                                    'data' => ['method' => 'post'],
                                ]) ?>
                                <?= $linha->quantidade ?>
                                <?= Html::a('+', ['linhas-carrinho/aumentar', 'id' => $linha->idLinhasCarrinho], [
                                    'class' => 'btn btn-success btn-sm',
                                    'data' => ['method' => 'post'],
                                ]) ?>
                                <?= Html::a('Remover', ['linhas-carrinho/remove', 'produto_id' => $linha->idLinhasCarrinho], [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data' => [
                                        'confirm' => 'Tem a certeza que quer remover este produto?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="col-12 text-center mt-4">
                <hr class="dl-divider">
                <p><strong>Total: €<?= number_format($carrinho->total, 2, ',', '.') ?></strong></p>

                <div class="dl-btn-container mt-4" style="display: flex; justify-content: center; align-items: center; margin-bottom: 15px;">
                    <?= Html::a('Checkout', ['carrinho/checkout'], ['class' => 'btn dl-btn-primary']) ?>
                    <?= Html::a('Voltar aos Produtos', ['site/product'], ['class' => 'btn dl-btn-secondary']) ?>
                </div>
            </div>

        <?php else: ?>
            <div class="col-12 text-center">
                <p>O seu carrinho está vazio.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
