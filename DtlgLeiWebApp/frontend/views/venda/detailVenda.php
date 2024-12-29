<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Venda $venda */
/** @var common\models\LinhasVenda[] $linhasVenda */

$this->title = "Detalhes da Venda #{$venda->idVenda}";
$this->params['breadcrumbs'][] = ['label' => 'Vendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="venda-detail">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><strong>Data da Venda:</strong> <?= Yii::$app->formatter->asDatetime($venda->datavenda) ?></p>
    <p><strong>Total:</strong> <?= $venda->total ?> €</p>
    <p><strong>Método de Pagamento:</strong> <?= $venda->metodoPagamento->designacao ?></p>
    <p><strong>Método de Entrega:</strong> <?= $venda->metodoEntrega->designacao ?></p>

    <h2>Linhas da Venda</h2>
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
                <td><?= Html::encode($linha->produto->nome) ?></td>
                <td><?= $linha->quantidade ?></td>
                <td><?= $linha->precounitario ?> €</td>
                <td><?= $linha->subtotal ?> €</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
