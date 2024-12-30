<?php
/** @var yii\web\View $this */
/** @var bool $isEligibleToReview */
/** @var common\models\Produto $product */
/** @var common\models\Avaliacao[] $avaliacoes */


use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Produto;

$idProduto = Yii::$app->request->get('idProduto');
$product = Produto::findOne($idProduto);

if (!$product) {
    throw new \yii\web\NotFoundHttpException("Produto não encontrado");
}

$this->title = 'DL | Detalhes do Produto';
$this->params['breadcrumbs'][] = $this->title;
?>

<head>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/styledata.css">
</head>

<body>
<section class="product_section">
    <div class="container">
        <div class="product-heading">
            <h2>Detalhes do Produto</h2>
        </div>
        <div class="product-container">
            <!-- Coluna Esquerda -->
            <div class="product-box">
                <div class="img-box">
                    <?php if (!empty($product->imagem)): ?>
                        <?= Html::img('@web/uploads/' . $product->imagem[0]->fileName, [
                            'alt' => $product->nome,
                            'class' => 'card-img-top',
                        ]) ?>
                    <?php else: ?>
                        <img src="/images/default-product.png" alt="Produto sem imagem" class="card-img-top">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Coluna Direita -->
            <div class="product-box">
                <div class="product-title">
                    <h2><?= Html::encode($product->nome) ?></h2>
                </div>
                <p class="product-description"><?= Html::encode($product->descricao) ?></p>
                <div class="product-price">
                    <?= Html::encode(number_format($product->preco, 2, ',', '.')) ?>€
                    <span class="stock-status"><?= $product->stock > 0 ? '| Em stock' : '| Esgotado' ?></span>
                </div>
                <div class="add-to-cart">
                    <div class="quantity-selector">
                        <button onclick="decreaseQuantity()">-</button>
                        <input type="number" value="1" min="1" id="quantity">
                        <button onclick="increaseQuantity()">+</button>
                        <button class="btn-add-to-cart">Adicionar ao carrinho</button>
                    </div>
                    <div>
                        <?= Html::a('Voltar para os Produtos', Url::to(['site/product']), [
                            'class' => 'btn-voltar-button'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Linha para dividir -->
        <hr>

        <!-- Comentário Section -->
        <h3 class="dl-avaliacoes-title">Avaliações</h3>
        <section class="dl-review-form-section">
            <h3 class="dl-review-form-title">Deixe sua Avaliação</h3>
            <?= Html::beginForm(['avaliacao/add-review'], 'post') ?>
            <?= Html::hiddenInput('idProduto', $product->idProduto) ?>

            <div class="dl-form-group">
                <label for="rating" class="dl-form-label">Nota:</label>
                <select name="rating" id="rating" class="dl-form-control">
                    <option value="" disabled selected>Escolha uma opção</option>
                    <option value="1">1 - Muito Mau</option>
                    <option value="2">2 - Mau</option>
                    <option value="3">3 - Satisfaz</option>
                    <option value="4">4 - Bom</option>
                    <option value="5">5 - Excelente</option>
                </select>
            </div>

            <div class="dl-form-group">
                <label for="comentario" class="dl-form-label">Comentário:</label>
                <textarea name="comentario" id="comentario" class="dl-form-control" rows="4"></textarea>
            </div>

            <div class="dl-form-group">
                <?= Html::submitButton('Enviar Avaliação', ['class' => 'dl-btn-primary']) ?>
            </div>
            <?= Html::endForm() ?>
        </section>

        <?php if (!empty($avaliacoes)): ?>
            <section class="dl-reviews-list">
                <?php foreach ($avaliacoes as $avaliacao): ?>
                    <div class="dl-review">
                        <p><strong>Nota:</strong> <?= Html::encode($avaliacao->rating) ?> / 5</p>
                        <p><strong>Comentário:</strong> <?= Html::encode($avaliacao->comentario) ?></p>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <hr>
            <p>Este produto ainda não possui avaliações.</p>
        <?php endif; ?>

        <?php if ($isEligibleToReview): ?>
            <h3 class="dl-review-form-title">Deixe sua Avaliação</h3>
            <?= Html::beginForm(['avaliacao/add-review'], 'post') ?>
            <?= Html::hiddenInput('idProduto', $product->idProduto) ?>

            <div class="dl-form-group">
                <label for="rating" class="dl-form-label">Nota:</label>
                <?= Html::input('number', 'rating', null, [
                    'id' => 'rating',
                    'class' => 'dl-form-control',
                    'min' => 1,
                    'max' => 5,
                    'required' => true,
                ]) ?>
            </div>

            <div class="dl-form-group">
                <label for="comentario" class="dl-form-label">Comentário:</label>
                <?= Html::textarea('comentario', '', [
                    'id' => 'comentario',
                    'class' => 'dl-form-control',
                    'rows' => 4,
                    'required' => true,
                ]) ?>
            </div>

            <?= Html::submitButton('Enviar Avaliação', ['class' => 'dl-btn-primary']) ?>
            <?= Html::endForm() ?>
        <?php else: ?>
            <p>Você deve comprar este produto antes de avaliá-lo.</p>
        <?php endif; ?>


    </div>
</section>

<script>
    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        if (quantityInput.value > 1) {
            quantityInput.value--;
        }
    }
    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        quantityInput.value++;
    }
</script>
</body>
