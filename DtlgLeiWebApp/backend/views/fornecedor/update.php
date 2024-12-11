<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Fornecedor $model */

$this->title = 'Update Fornecedor: ' . $model->idfornecedor;
$this->params['breadcrumbs'][] = ['label' => 'Fornecedors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idfornecedor, 'url' => ['view', 'idfornecedor' => $model->idfornecedor]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fornecedor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
