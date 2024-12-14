<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use frontend\assets\AppAsset;

$this->title = 'DL | Carrinho de Compras';
$this->params['breadcrumbs'][] = $this->title;
?>

<head>
    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
</head>

<body class="sub_page">
<!-- Cart section -->
<section class="cart_section">
    <div class="container">
        <div class="cart_heading">
            <h2>Carrinho de Compras</h2>
        </div>

        <!-- Tabela de produtos no carrinho -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Artigo</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><img src="images/w1.png" alt="Produto 1" class="cart-img"></td>
                <td>Produto 1 - Descrição breve</td>
                <td>10€</td>
                <td>2</td>
                <td>20€</td>
            </tr>
            <tr>
                <td><img src="images/w2.png" alt="Produto 2" class="cart-img"></td>
                <td>Produto 2 - Descrição breve</td>
                <td>15€</td>
                <td>1</td>
                <td>15€</td>
            </tr>
            <tr>
                <td><img src="images/w3.png" alt="Produto 3" class="cart-img"></td>
                <td>Produto 3 - Descrição breve</td>
                <td>20€</td>
                <td>1</td>
                <td>20€</td>
            </tr>
            </tbody>
        </table>

        <!-- Sumário do carrinho -->
        <div class="cart-summary">
            <h3>Sumário</h3>
            <ul>
                <li><strong>Subtotal:</strong> 55€</li>
                <li><strong>IVA (23%):</strong> 12.65€</li>
                <li><strong>Total:</strong> 67.65€</li>
            </ul>
            <a href="#" class="btn btn-primary checkout-btn">Checkout</a>
        </div>
    </div>
</section>
<!-- End cart section -->

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<style>
    .cart_section {
        margin-top: 50px;
        margin-bottom: 50px;
    }

    .cart-heading h2 {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .cart-img {
        width: 50px;
        height: 50px;
    }

    .cart-summary {
        margin-top: 30px;
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .cart-summary h3 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .cart-summary ul {
        list-style: none;
        padding-left: 0;
    }

    .cart-summary ul li {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .checkout-btn {
        font-size: 18px;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }

    .checkout-btn:hover {
        background-color: #0056b3;
    }
</style>
