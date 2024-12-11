<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Metodoentrega $model */

$this->title = $model->idmetodoEntrega;
$this->params['breadcrumbs'][] = ['label' => 'Metodoentregas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="metodoentrega-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idmetodoEntrega' => $model->idmetodoEntrega], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idmetodoEntrega' => $model->idmetodoEntrega], [
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
            'idmetodoEntrega',
            'designacao',
        ],
    ]) ?>

</div>
