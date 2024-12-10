<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Dropdown;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Products', 'url' => ['/site/product']],
        ['label' => 'Contact Us', 'url' => ['/site/contact']],
        ['label' => 'About Us', 'url' => ['/site/about']]
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);

    $myAccountItems = [];
    if (Yii::$app->user->isGuest) {
        $myAccountItems = [
            ['label' => 'Signup', 'url' => ['/site/signup']],
            ['label' => 'Login', 'url' => ['/site/login']],
        ];
    } else {
        $myAccountItems = [
            ['label' => 'Profile', 'url' => ['/site/detailed-profile']],
            HTML::beginForm(['/site/logout'], 'post'),
            HTML::submitButton('Logout ('. Yii::$app->user->identity->username .')', ['class' => 'btn text-decoration-none']),
            HTML::endForm()
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-md-0 d-flex'],
        'items' => [
            [
                'label' => Html::tag('i', '', ['class' => 'fa fa-user', 'aria-hidden' => 'true']),
                'encode' => false,
                'items' => $myAccountItems,
            ],
            [
                'label' => Html::tag('i', '', ['class' => 'fa fa-shopping-cart', 'aria-hidden' => 'true']),
                'encode' => false,
            ],
        ],
    ]);
    NavBar::end();
    ?>

</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

    <!-- info section -->
<section class="info_section layout_padding2">
    <div class="container">
        <div class="info_logo">
            <h2>
                HandTime
            </h2>
        </div>
        <div class="row">

            <div class="col-md-3">
                <div class="info_contact">
                    <h5>
                        About Shop
                    </h5>
                    <div>
                        <div class="img-box">
                            <img src="images/location-white.png" width="18px" alt="">
                        </div>
                        <p>
                            Address
                        </p>
                    </div>
                    <div>
                        <div class="img-box">
                            <img src="images/telephone-white.png" width="12px" alt="">
                        </div>
                        <p>
                            +01 1234567890
                        </p>
                    </div>
                    <div>
                        <div class="img-box">
                            <img src="images/envelope-white.png" width="18px" alt="">
                        </div>
                        <p>
                            demo@gmail.com
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info_info">
                    <h5>
                        Informations
                    </h5>
                    <p>
                        ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info_insta">
                    <h5>
                        Instagram
                    </h5>
                    <div class="insta_container">
                        <div class="row m-0">
                            <div class="col-4 px-0">
                                <a href="">
                                    <div class="insta-box b-1">
                                        <img src="images/w1.png" alt="">
                                    </div>
                                </a>
                            </div>
                            <div class="col-4 px-0">
                                <a href="">
                                    <div class="insta-box b-1">
                                        <img src="images/w2.png" alt="">
                                    </div>
                                </a>
                            </div>
                            <div class="col-4 px-0">
                                <a href="">
                                    <div class="insta-box b-1">
                                        <img src="images/w3.png" alt="">
                                    </div>
                                </a>
                            </div>
                            <div class="col-4 px-0">
                                <a href="">
                                    <div class="insta-box b-1">
                                        <img src="images/w4.png" alt="">
                                    </div>
                                </a>
                            </div>
                            <div class="col-4 px-0">
                                <a href="">
                                    <div class="insta-box b-1">
                                        <img src="images/w5.png" alt="">
                                    </div>
                                </a>
                            </div>
                            <div class="col-4 px-0">
                                <a href="">
                                    <div class="insta-box b-1">
                                        <img src="images/w6.png" alt="">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info_form ">
                    <h5>
                        Newsletter
                    </h5>
                    <form action="">
                        <input type="email" placeholder="Enter your email">
                        <button>
                            Subscribe
                        </button>
                    </form>
                    <div class="social_box">
                        <a href="">
                            <img src="images/fb.png" alt="">
                        </a>
                        <a href="">
                            <img src="images/twitter.png" alt="">
                        </a>
                        <a href="">
                            <img src="images/linkedin.png" alt="">
                        </a>
                        <a href="">
                            <img src="images/youtube.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->endBody() ?>
<?php $this->endPage() ?>
