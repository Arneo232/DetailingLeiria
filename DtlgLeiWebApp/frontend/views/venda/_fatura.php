<?php
use yii\helpers\Html;

/* @var $venda app\models\Venda /
/ @var $linhasVenda app\models\LinhasVenda[] */

?>

<h1>Recibo da Venda #<?= Html::encode($venda->idVenda) ?></h1>
<p><strong>Data:</strong> <?= Yii::$app->formatter->asDatetime($venda->datavenda) ?></p>
<p><strong>Total:</strong> <?= Yii::$app->formatter->asCurrency($venda->total) ?></p>

<h2>Itens:</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
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
            <td><?= Html::encode($linha->quantidade) ?></td>
            <td><?= Yii::$app->formatter->asCurrency($linha->precounitario) ?></td>
            <td><?= Yii::$app->formatter->asCurrency($linha->subtotal) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
