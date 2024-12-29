<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Venda $model */
/** @var common\models\LinhasVenda[] $linhasVenda */

$this->title = 'Fatura #'. $model->idVenda;
$this->params['breadcrumbs'][] = ['label' => 'Vendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Fatura'];
\yii\web\YiiAsset::register($this);

?>
<div class="venda-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idVenda',
            'total',
            'datavenda',
            [
                'attribute' => 'metodoPagamento_id',
                'label' => 'Método de Pagamento',
                'value' => function ($model) {
                    return $model->metodoPagamento->designacao ?? 'Não especificado';
                },
            ],
            [
                'attribute' => 'metodoEntrega_id',
                'label' => 'Método de Entrega',
                'value' => function ($model) {
                    return $model->metodoEntrega->designacao ?? 'Não especificado';
                },
            ],
            'idCarrinhoFK',
            'idProfileFK',
        ],
    ]) ?>


    <h2>Produtos Comprados</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($linhasVenda as $linha): ?>
            <tr>
                <td><?= Html::encode($linha->produto->nome ?? 'Produto não encontrado') ?></td>
                <td><?= Html::encode($linha->quantidade) ?></td>
                <td><?= Yii::$app->formatter->asCurrency($linha->precounitario) ?></td>
                <td><?= Yii::$app->formatter->asCurrency($linha->subtotal) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
