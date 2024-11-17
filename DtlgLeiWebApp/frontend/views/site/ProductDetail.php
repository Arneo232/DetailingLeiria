<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

$this->title = 'DL | Detalhes do Produto';
$this->params['breadcrumbs'][] = $this->title;

?>

<head>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <style>
        .product-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .product-title h2 {
            margin: 0;
            font-size: 26px;
            font-weight: bold;
        }
        .star_container {
            display: flex;
            gap: 5px;
        }
        .star_container i {
            color: #f39c12;
        }

        .product-price {
            font-size: 22px;
            font-weight: bold;
            color: #28a745;
        }
        .add-to-cart {
            margin-top: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .quantity-selector {
            display: flex;
            align-items: center;
        }
        .quantity-selector input {
            width: 50px;
            text-align: center;
            margin: 0 10px;
        }
        .add-to-cart button {
            background-color: rgba(0, 164, 224, 0.94);
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            color: #fff;
        }
        .add-to-cart button:hover {
            background-color: #004ee0;
        }
        .btn-voltar-button {
            display: inline-block;
            background-color: rgba(25, 25, 25, 0.94);
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-voltar-button:hover {
            background-color: #004ee0;
        }
    </style>
</head>

<body>
<section class="product_section ">
    <div class="container">
        <div class="product_heading">
            <h2>
                Detalhes do Produto
            </h2>
        </div>
        <div class="product-container">
            <div class="box-content">
                <!-- Nota: colocar Carousel de imgs -->
                <div class="img-box">
                    <img src="images/w1.png" alt="Principal">
                </div>

                <!-- Informações do Produto -->
                <div class="product-info">
                    <div class="product-title">
                        <h2>Magic Shampoo 750ml - Champô Protetor</h2>
                        <div class="star_container">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p>
                        Magic Shampoo é nada mais nada menos do que um sabão para automóveis com proteção cerâmica, o que significa que proporciona uma camada de proteção duradoura a todas as superfícies do exterior do automóvel que repele a sujidade, a água e o pó, mantendo o automóvel mais limpo durante mais tempo.
                    </p>
                    <p>
                        Nos automóveis com cera ou revestimento cerâmico, mantém e prolonga a vida útil do tratamento e, nos automóveis não tratados, proporciona um elevado brilho e proteção contra a poluição rodoviária, excrementos de pássaros e mosquitos, bem como um toque suave e sedoso da pintura.
                    </p>
                </div>

                <div class="detail-box">
                        <div class="product-price">
                            13,95€ <span class="stock-status">| Em stock</span>
                        </div>
                    </div>
                    <!-- Botoes -->
                    <div class="add-to-cart">
                        <div class="quantity-selector">
                            <button onclick="decreaseQuantity()">-</button>
                            <input type="number" value="1" min="1" id="quantity">
                            <button onclick="increaseQuantity()">+</button>
                        </div>
                        <button>Adicionar ao carrinho</button>
                        <div class="btn-voltar">
                            <?= Html::a('Voltar para os Produtos', Url::to(['site/product']), [
                                    'class' => 'btn-voltar-button'
                            ]) ?>
                        </div>
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
