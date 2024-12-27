<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Favorito;

/** @var yii\web\View $this */
/** @var common\models\Product[] $products */

$this->title = 'DL | Favoritos';
$this->params['breadcrumbs'][] = $this->title;

// Fetch the user's favourites
$favoritos = Favorito::find()->where(['profile_id' => Yii::$app->user->identity->profile->idprofile])->all();
?>

<header>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/styledata.css">
</header>
<div class="container">
    <h2 class="text-center my-4 font-weight-bold">Produtos Favoritos</h2>

    <!-- Linha para dividir -->
    <hr class="dl-divider">

    <!-- Favoritos -->
    <div class="row">
        <?php if (!empty($favoritos)): ?>
            <?php foreach ($favoritos as $favorito): ?>
                <?php $product = $favorito->produto; // Access the related product ?>
                <?php if ($product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-img-top">
                                <?php if (!empty($product->imagem)): ?>
                                    <?= Html::img('../uploads/' . $product->imagem[0]->fileName, [
                                        'alt' => $product->nome,
                                        'class' => 'card-img-top',
                                        'style' => 'height: 200px; object-fit: cover;',
                                    ]) ?>
                                <?php else: ?>
                                    <img src="/images/default-product.png" alt="Produto sem imagem" class="card-img-top" style="height: 200px; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= Html::encode($product->nome) ?></h5>
                                <p class="card-text">Preço: €<?= Html::encode(number_format($product->preco, 2, ',', '.')) ?></p>
                                <div class="dl-btn-container">
                                    <a href="<?= Url::to(['site/product-detail', 'idProduto' => $product->idProduto]) ?>" class="btn dl-btn-primary">Ver Detalhes</a>
                                    <a class="btn btn-sm btn-danger"
                                       href="<?= yii\helpers\Url::to(['favorito/remover', 'idfavorito' => $favorito->idfavorito]) ?>"><i class="fa fa-times"></i>Remover</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Não há produtos nos seus favoritos ainda.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
