<?php

/** @var yii\web\View $this */

use frontend\assets\AppAsset;

$this->title = 'Detailing Leiria';
$this->params['breadcrumbs'][] = $this->title;
?>
<head>
    <title>Detailing Leiria</title>
</head>

<body>
<div class="hero_area">
    <!-- end header section -->

    <!-- slider section -->
    <section class="slider_section ">
        <div class="slider_bg_box">
            <img src="<?= Yii::getAlias('@web') ?>/images/Abutre.jpg" alt="Capa do site">
        </div>
        <div id="customCarousel1" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container ">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="detail-box">
                                    <h1>
                                        Bem-vindo ao Detailing Leiria!
                                    </h1>
                                    <p>
                                        A sua plataforma de referência para encontrar os melhores produtos e serviços de limpeza automóvel.
                                        Aqui, ajudamos a cuidar do seu carro como ele merece!
                                    </p>
                                    <div class="btn-box">
                                        <a href="site/contact" class="btn1">
                                            Contact Us
                                        </a>
                                        <a href="site/about" class="btn2">
                                            About Us
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container ">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="detail-box">
                                    <h1>
                                        OS Melhores Produtos!
                                    </h1>
                                    <p>
                                        Descubra qualidade e inovação nos melhores produtos para cuidar do seu automóvel!
                                    </p>
                                    <div class="btn-box">
                                        <a href="site/product" class="btn1">
                                            Products
                                        </a>
                                        <a href="site/about" class="btn2">
                                            About Us
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container ">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="detail-box">
                                    <h1>
                                        Eleve a sua experiencia de compra!
                                    </h1>
                                    <p>
                                        Junte-se a nós e transforme a sua experiência de compras numa jornada única e prática!
                                    </p>
                                    <div class="btn-box">
                                        <a href="site/signup" class="btn1">
                                            Register
                                        </a>
                                        <a href="site/about" class="btn2">
                                            About Us
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ol class="carousel-indicators">
                <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
                <li data-target="#customCarousel1" data-slide-to="1"></li>
                <li data-target="#customCarousel1" data-slide-to="2"></li>
            </ol>
        </div>

    </section>
    <!-- end slider section -->
</div>


<!-- service section -->

<section class="service_section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="box ">
                    <div class="img-box">
                        <img src="<?= Yii::getAlias('@web') ?>/images/feature-1.png" alt="">
                    </div>
                    <div class="detail-box">
                        <h5>
                            Entregas rápidas
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="box ">
                    <div class="img-box">
                        <img src="<?= Yii::getAlias('@web') ?>/images/feature-2.png" alt="">
                    </div>
                    <div class="detail-box">
                        <h5>
                            Entregas grátis
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="box ">
                    <div class="img-box">
                        <img src="<?= Yii::getAlias('@web') ?>/images/feature-3.png" alt="">
                    </div>
                    <div class="detail-box">
                        <h5>
                            Melhor Qualidade
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="box ">
                    <div class="img-box">
                        <img src="<?= Yii::getAlias('@web') ?>/images/feature-4.png" alt="">
                    </div>
                    <div class="detail-box">
                        <h5>
                            24x7 Suporte ao cliente
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- end service section -->


<!-- about section -->

<section class="about_section layout_padding">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="img_container">
                    <div class="img-box b1">
                        <img src="<?= Yii::getAlias('@web') ?>/images/about-img.jpg" alt="selo de qualidade">
                    </div>
                    <div class="img-box b2">
                        <img src="<?= Yii::getAlias('@web') ?>/images/Logo_white.png" alt="Logo do DL">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-box">
                    <h2>
                        Sobre a nossa loja
                    </h2>
                    <p>
                        O Detailing Leiria é um site dedicado à venda de produtos de limpeza para automóveis, com foco na facilidade de navegação e segurança nas transações.
                        O objetivo é garantir que os clientes encontrem rapidamente o que precisam, com informações claras sobre os produtos e opções de pagamento seguras.
                        O site também visa oferecer um bom desempenho e qualidade nas entregas, proporcionando uma experiência de compra confiável e prática.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
</body>