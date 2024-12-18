<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Desconto $model */

$this->title = $model->iddesconto;
$this->params['breadcrumbs'][] = ['label' => 'Descontos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="desconto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'iddesconto' => $model->iddesconto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'iddesconto' => $model->iddesconto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'iddesconto',
            'desconto',
        ],
    ]) ?>

</div>
