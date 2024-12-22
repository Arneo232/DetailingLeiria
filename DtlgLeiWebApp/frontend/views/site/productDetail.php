<?php
/** @var yii\web\View $this */

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
        <div class="product_heading">
            <h2>Detalhes do Produto</h2>
        </div>
        <div class="product-container">
            <div class="box-content">
                <!-- Exibir a imagem do produto ou imagem padrão -->
                <div class="img-box">
                    <?php if (!empty($product->imagem)): ?>
                        <?= Html::img('@web/uploads/' . $product->imagem[0]->fileName, [
                            'alt' => $product->nome,
                            'class' => 'card-img-top',
                            'style' => 'height: 300px; object-fit: cover;',
                        ]) ?>
                    <?php else: ?>
                        <img src="/images/default-product.png" alt="Produto sem imagem" class="card-img-top" style="height: 300px; object-fit: cover;">
                    <?php endif; ?>
                </div>

                <!-- Informações do Produto -->
                <div class="product-title">
                    <h2><?= Html::encode($product->nome) ?></h2>
                </div>
                <p><?= Html::encode($product->descricao) ?></p>
                <div class="product-price">
                    <?= Html::encode(number_format($product->preco, 2, ',', '.')) ?>€
                    <span class="stock-status"><?= $product->stock > 0 ? '| Em stock' : '| Esgotado' ?></span>
                </div>

                <!-- Botoes -->
                <div class="add-to-cart">
                    <div class="quantity-selector">
                        <button onclick="decreaseQuantity()">-</button>
                        <input type="number" value="1" min="1" id="quantity">
                        <button onclick="increaseQuantity()">+</button>
                        <button class="btn-add-to-cart">Adicionar ao carrinho</button>
                    </div>
                    <div class="btn-voltar">
                        <?= Html::a('Voltar para os Produtos', Url::to(['site/product']), [
                            'class' => 'btn-voltar-button'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
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
