<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use frontend\assets\AppAsset;

$this->title = 'DL | About Us';
$this->params['breadcrumbs'][] = $this->title;

?>
<head>
    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
</head>

<!-- about section -->
<body>
    <section class="about_section layout_padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="img_container">
                        <div class="img-box b1">
                            <img src="../web/images/a-1.jpg" alt="">
                        </div>
                        <div class="img-box b2">
                            <img src="../web/images/a-2.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-box">
                        <h2>
                            About Our Shop
                        </h2>
                        <p>
                            There are many variations of passages of Lorem Ipsum
                            There are many variations of
                            passages of Lorem Ipsum
                        </p>
                        <a href="">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
