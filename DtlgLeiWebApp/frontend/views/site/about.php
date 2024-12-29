<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

$this->title = 'DL | About Us';
$this->params['breadcrumbs'][] = $this->title;

?>
<head>

</head>

<!-- about section -->
<body>
    <section class="about_section layout_padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="img_container">
                        <div class="img-box b1">
                            <img src="<?= Yii::getAlias('@web') ?>/images/DL_Logo.jpg" alt="Logo do site">
                        </div>
                        <div class="img-box b2">
                            <img src="<?= Yii::getAlias('@web') ?>/images/C_Limpo.jpg" alt="Carro Limpo">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-box">
                        <h2>
                            About Our Shop
                        </h2>
                        <p>
                            O Detailing Leiria é uma solução prática para quem procura produtos de limpeza automóvel.
                            A nosso site facilita o acesso, a compra e mantém-no atualizado com promoções e
                            novidades.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>