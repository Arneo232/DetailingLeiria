<?php
/** @var yii\web\View $this */
/** @var common\models\Produto $product */
/** @var common\models\Avaliacao[] $avaliacoes */
/** @var common\models\Avaliacao $reviewModel */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Produto;
use common\models\Avaliacao;

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
                        <?php if (!Yii::$app->user->isGuest): ?>
                            <button onclick="decreaseQuantity()">-</button>
                            <input type="number" value="1" min="1" id="quantity">
                            <button onclick="increaseQuantity()">+</button>
                            <a class="btn dl-btn-primary" href="<?= yii\helpers\Url::to(['linhas-carrinho/adicionar', 'produto_id' => $product->idProduto]) ?>"><i class="fa fa-cart-plus"></i></a>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?= Html::a('Voltar para os Produtos', Url::to(['site/product']), [
                            'class' => 'btn-voltar-button'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <h3 class="dl-avaliacoes-title">Avaliações</h3>
        <div class="avaliacoes-container">
            <?php if (!empty($avaliacoes)): ?>
                <?php foreach ($avaliacoes as $avaliacao): ?>
                    <div class="avaliacao">
                        <strong>Nota:</strong> <?= Html::encode($avaliacao->rating) ?> / 5<br>
                        <strong>Comentário:</strong> <?= Html::encode($avaliacao->comentario) ?><br>
                        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id == $avaliacao->profile->user->id): ?>
                            <?= Html::a('Remover', ['avaliacao/remover-avaliacao', 'idavaliacao' => $avaliacao->idavaliacao, 'idProduto' => $idProduto], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Tem acerteza de que deseja apagar esta avaliação?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>
                        <hr>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Ninguém deu uma avaliação neste produto.</p>
            <?php endif; ?>
        </div>
        <?php if (!Yii::$app->user->isGuest): ?>
            <h3 class="dl-avaliacoes-title">Escrever Avaliação</h3>
            <?= $this->render('//avaliacao/_form', [
                'reviewModel' => $reviewModel,
                'idProduto' => $product->idProduto,
            ]) ?>
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
