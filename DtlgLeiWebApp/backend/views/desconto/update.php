<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Desconto $model */

$this->title = 'Update Desconto: ' . $model->iddesconto;
$this->params['breadcrumbs'][] = ['label' => 'Descontos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iddesconto, 'url' => ['view', 'iddesconto' => $model->iddesconto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="desconto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
