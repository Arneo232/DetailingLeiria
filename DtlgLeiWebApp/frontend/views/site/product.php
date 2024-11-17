<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use frontend\assets\AppAsset;

$this->title = 'DL | Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>

<head>
    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
</head>

<body class="sub_page">
<!-- product section -->

<section class="product_section">
    <div class="container">
        <div class="product_heading">
            <h2>Lista de Produtos</h2>
        </div>

        <!-- Filtros -->
        <div class="filters_section">
            <h3 class="filters-title" data-toggle="collapse" data-target="#filters-collapse" aria-expanded="false" aria-controls="filters-collapse">
                Filtros
            </h3>

            <div id="filters-collapse" class="collapse filters-container">
                <form method="get" action="" class="filter-form">
                    <div class="form-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Pesquisar por nome" />
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="product-type" name="type">
                            <option value="">Tipo</option>
                            <option value="tipo1">Tipo 1</option>
                            <option value="tipo2">Tipo 2</option>
                            <option value="tipo3">Tipo 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Preço</label>
                        <input type="text" id="amount" class="form-control" readonly="readonly" />
                        <div id="slider-range"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                </form>
            </div>
        </div>

        <div class="product_container">
            <!-- Exemplo de Produto 1 -->
            <div class="box">
                <div class="box-content">
                    <div class="img-box">
                        <?= Html::a(
                            Html::img('images/w1.png', ['alt' => 'Produto']),
                            ['site/product-detail']
                        ) ?>
                    </div>
                    <div class="detail-box">
                        <div class="text">
                            <h6>Men's Watch</h6>
                            <h5><span>$</span> 300</h5>
                        </div>
                        <div class="like">
                            <h6>Like</h6>
                            <div class="star_container">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-box">
                    <a href="">Add To Cart</a>
                </div>
            </div>

            <!-- Exemplo de Produto 2 -->
            <div class="box">
                <div class="box-content">
                    <div class="img-box">
                        <img src="images/w2.png" alt="">
                    </div>
                    <div class="detail-box">
                        <div class="text">
                            <h6>Men's Watch</h6>
                            <h5><span>$</span> 300</h5>
                        </div>
                        <div class="like">
                            <h6>Like</h6>
                            <div class="star_container">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-box">
                    <a href="">Add To Cart</a>
                </div>
            </div>

            <!-- Exemplo de Produto 3 -->
            <div class="box">
                <div class="box-content">
                    <div class="img-box">
                        <img src="images/w3.png" alt="">
                    </div>
                    <div class="detail-box">
                        <div class="text">
                            <h6>Men's Watch</h6>
                            <h5><span>$</span> 300</h5>
                        </div>
                        <div class="like">
                            <h6>Like</h6>
                            <div class="star_container">
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-box">
                    <a href="">Add To Cart</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- end product section -->

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<style>
    .filters_section {
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .filters-title {
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        color: #007bff;
        text-transform: uppercase;
        padding-left: 10px;
        transition: color 0.3s ease-in-out;
    }
    .filters-title:hover {
        color: #0056b3;
    }
    .filters-container {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-top: 15px;
    }

    .filter-form .form-group {
        margin-bottom: 10px;
        width: 30%;
        display: inline-block;
        margin-right: 10px;
    }
    .filter-form .form-control {
        width: 100%;
    }

    .filter-form button {
        margin-top: 10px;
    }
</style>
