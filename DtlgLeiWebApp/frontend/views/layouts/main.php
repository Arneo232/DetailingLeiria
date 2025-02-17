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
    <link rel="icon" type="image/x-icon" href="<?= Yii::getAlias('@web') ?>/images/favicon.ico">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
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
            ['label' => 'Faturas', 'url' => ['/venda/index']],
            HTML::beginForm(['/site/logout'], 'post'),
            HTML::submitButton('Logout ('. Yii::$app->user->identity->username .')', ['class' => 'btn text-decoration-none']),
            HTML::endForm()
        ];
    }

    $additionalItems = [];
    if (!Yii::$app->user->isGuest) {
        $additionalItems = [
            [
                'label' => Html::tag('i', '', ['class' => 'fa fa-shopping-cart', 'aria-hidden' => 'true']),
                'encode' => false,
                'url' => ['/carrinho/index'],
            ],
            [
                'label' => Html::tag('i', '', ['class' => 'fa fa-star', 'aria-hidden' => 'true']),
                'encode' => false,
                'url' => ['/favorito/index'],
            ],
        ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto mb-2 mb-md-0 d-flex'],
        'items' => array_merge([
            [
                'label' => Html::tag('i', '', ['class' => 'fa fa-user', 'aria-hidden' => 'true']),
                'encode' => false,
                'items' => $myAccountItems,
            ],
        ], $additionalItems),
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
        <div class="info_logo text-center">
            <h2>
                Detailing Leiria
            </h2>
        </div>
        <div class="row d-flex justify-content-center text-center">
            <div class="col-md-3">
                <div class="info_contact">
                    <h5>
                        Temos uma App!
                    </h5>
                    <div>
                        <div class="img-box mx-auto">
                            <img src="<?= Yii::getAlias('@web') ?>/images/telephone-white.png" width="12px" alt="">
                        </div>
                        <p>
                            Faça download da nossa App!
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info_info">
                    <h5>
                        Info
                    </h5>
                    <p>
                        A sua plataforma para os melhores produtos de limpeza automóvel.
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info_form">
                    <h5>
                        Newsletter
                    </h5>
                    <form action="">
                        <input type="email" placeholder="Enter your email">
                        <button>
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="social_box d-flex justify-content-center mt-3">
            <a href="" class="mx-2">
                <img src="<?= Yii::getAlias('@web') ?>/images/fb.png" alt="">
            </a>
            <a href="" class="mx-2">
                <img src="<?= Yii::getAlias('@web') ?>/images/twitter.png" alt="">
            </a>
            <a href="" class="mx-2">
                <img src="<?= Yii::getAlias('@web') ?>/images/linkedin.png" alt="">
            </a>
            <a href="" class="mx-2">
                <img src="<?= Yii::getAlias('@web') ?>/images/youtube.png" alt="">
            </a>
        </div>
    </div>
</section>


<?php $this->endBody() ?>
<?php $this->endPage() ?>
