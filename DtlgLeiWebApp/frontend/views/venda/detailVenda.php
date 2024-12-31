<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Venda $venda */
/** @var common\models\LinhasVenda[] $linhasVenda */

$this->title = "DL | Detalhes da Venda #{$venda->idVenda}";
$this->params['breadcrumbs'][] = ['label' => 'Vendas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<header>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/styledata.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</header>

<div class="dl-venda-detail">
    <div class="dl-venda-card">
        <div class="dl-venda-header">
            <h1 class="dl-venda-title">Detalhes da Venda #<?= Html::encode($venda->idVenda) ?></h1>
            <p><strong>Data da Venda:</strong> <?= Yii::$app->formatter->asDatetime($venda->datavenda) ?></p>
            <p><strong>Total:</strong> <?= $venda->total ?> €</p>
            <p><strong>Método de Pagamento:</strong> <?= $venda->metodoPagamento->designacao ?></p>
            <p><strong>Método de Entrega:</strong> <?= $venda->metodoEntrega->designacao ?></p>
        </div>

        <div class="dl-venda-details">
            <h2 class="dl-venda-subtitle">Linhas da Venda</h2>
            <table class="dl-venda-table">
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
    </div>

    <div class="dl-logo-footer">
        <img src="<?= Yii::getAlias('@web') ?>/images/DL_Logo.jpg" alt="Logo do DL" class="dl-footer-logo">
    </div>
</div>
