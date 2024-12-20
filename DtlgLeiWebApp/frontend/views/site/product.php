<?php
/** @var yii\web\View $this */
/** @var common\models\Product[] $products */

use yii\helpers\Html;

$this->title = 'DL | Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <h2 class="text-center my-4">Lista de Produtos</h2>

    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-img-top">
                        <?php foreach ($product->imagem as $imagem): ?>
                         <?= Html::img('../uploads/' . $imagem->fileName, [
                            'alt' => $product->nome,
                            'class' => 'card-img',
                        ]) ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= Html::encode($product->nome) ?></h5>
                        <p class="card-text">Preço: $<?= Html::encode($product->preco) ?></p>
                        <a href="#" class="btn btn-primary">Adicionar ao Carrinho</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
