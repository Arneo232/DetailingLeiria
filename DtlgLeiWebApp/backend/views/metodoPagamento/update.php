<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Metodopagamento $model */

$this->title = 'Update Metodopagamento: ' . $model->idMetodoPagamento;
$this->params['breadcrumbs'][] = ['label' => 'Metodopagamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idMetodoPagamento, 'url' => ['view', 'idMetodoPagamento' => $model->idMetodoPagamento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="metodopagamento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
