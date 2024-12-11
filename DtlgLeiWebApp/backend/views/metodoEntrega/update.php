<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Metodoentrega $model */

$this->title = 'Update Metodoentrega: ' . $model->idmetodoEntrega;
$this->params['breadcrumbs'][] = ['label' => 'Metodoentregas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idmetodoEntrega, 'url' => ['view', 'idmetodoEntrega' => $model->idmetodoEntrega]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metodoentrega-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
