<?php

use common\models\Carrinho;
use common\models\Linhascarrinho;
use common\models\Produto;
use common\models\Metodopagamento;
use common\models\Metodoentrega;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Carrinhos';
$this->params['breadcrumbs'][] = $this->title;

// Fetch the user's cart
$carrinho = Carrinho::find()->where(['idProfile' => Yii::$app->user->identity->profile->idprofile])->one();
$linhasCarrinho = $carrinho ? Linhascarrinho::findAll(['carrinho_id' => $carrinho->idCarrinho]) : [];
?>
<div class="container">
    <h1>Shopping Cart</h1>

    <?php if (!empty($linhasCarrinho)): ?>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Subtotal</th>
                <th>Quantidade</th>
                <th>Remover</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($linhasCarrinho as $linha): ?>
                <tr>
                    <td><?= $linha->produto->nome ?></td>
                    <td><?= number_format($linha->precounitario, 2) ?>€</td>
                    <td><?= number_format($linha->subtotal, 2) ?>€</td>
                    <td>
                        <?= Html::a('-', ['linhas-carrinho/retirar', 'id' => $linha->idLinhasCarrinho], [
                            'class' => 'btn btn-warning btn-sm',
                            'data' => ['method' => 'post'],
                        ]) ?>
                        <?= $linha->quantidade ?>
                        <?= Html::a('+', ['linhas-carrinho/aumentar', 'id' => $linha->idLinhasCarrinho], [
                            'class' => 'btn btn-success btn-sm',
                            'data' => ['method' => 'post'],
                        ]) ?>
                    </td>
                    <td>
                        <?= Html::a('Remover', ['linhas-carrinho/remove', 'produto_id' => $linha->idLinhasCarrinho],
                            [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Tem a certeza que quer remover este produto?',
                                    'method' => 'post',
                                ],
                            ])
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p>Total: <?= number_format($carrinho->total, 2) ?>€</p>
        <?= Html::a('Checkout', ['carrinho/checkout'], ['class' => 'btn btn-success']) ?>
    <?php else: ?>
        <p>O seu carrinho está vazio.</p>
    <?php endif; ?>
</div>
