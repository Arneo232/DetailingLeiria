<?php
/** @var yii\web\View $this */
/** @var common\models\Product[] $products */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Favorito;

$this->title = 'DL | Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<header>
<link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/styledata.css">
</header>
<div class="container">
    <h2 class="text-center my-4 font-weight-bold">Lista de Produtos</h2>

    <!-- Filtros -->
    <div class="dl-filters-section">
        <h3 class="dl-filters-title" data-toggle="collapse" data-target="#dl-filters-collapse" aria-expanded="false" aria-controls="dl-filters-collapse">
            Filtros
        </h3>

        <div id="dl-filters-collapse" class="collapse dl-filters-container">
            <form method="get" action="" class="dl-filter-form">
                <div class="form-group">
                    <input type="text" class="form-control" name="keyword" placeholder="Pesquisar por nome" />
                </div>
                <div method="GET" class="form-group">
                    <label for="product-type">Escolha uma categoria:</label>
                    <select class="form-control" id="product-type" name="categoria" aria-label="Escolha uma categoria">
                        <option value="" selected>Categorias</option>
                        <?php if (isset($categorias) && !empty($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= htmlspecialchars($categoria->idCategoria, ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($categoria->designacao, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>Nenhuma categoria disponível</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dl-amount">Preço</label>
                    <input type="text" id="dl-amount" class="form-control" readonly="readonly" />
                    <div id="dl-slider-range"></div>
                </div>
                <button type="submit" class="btn dl-btn-primary">Aplicar Filtros</button>
            </form>
        </div>
    </div>

    <!-- Linha para dividir -->
    <hr class="dl-divider">

    <!-- Produtos -->
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-img-top">
                        <?php if (!empty($product->imagem)): ?>
                            <?= Html::img('../uploads/' . $product->imagem[0]->fileName, [
                                'alt' => $product->nome,
                                'class' => 'card-img-top',
                                'style' => 'height: 200px; object-fit: cover;',
                            ]) ?>
                        <?php endif; ?>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= Html::encode($product->nome) ?></h5>
                        <p class="card-text">Preço: €<?= Html::encode(number_format($product->preco, 2, ',', '.')) ?></p>
                        <div class="dl-btn-container">
                            <a href="<?= Url::to(['site/product-detail', 'idProduto' => $product->idProduto]) ?>" class="btn dl-btn-primary">Ver Detalhes</a>
                            <a href="#" class="btn dl-btn-primary"><i class="fa fa-cart-plus"></i></a>
                            <?php if (!Yii::$app->user->isGuest):
                                $favorito = Favorito::find()->where(['produto_id' => $product->idProduto, 'profile_id' => Yii::$app->user->identity->profile->idprofile])->one(); ?>
                                <a class="btn dl-btn-primary" href="<?= yii\helpers\Url::to(['favorito/adicionar', 'produto_id' => $product->idProduto]) ?>"><i class="fa fa-star"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
