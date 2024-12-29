<?php
/** @var yii\web\View $this */
/** @var common\models\Venda[] $vendas */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'DL | Faturas';
$this->params['breadcrumbs'][] = $this->title;
?>
<header>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/styledata.css">
</header>
<div class="container">
    <h2 class="text-center my-4 font-weight-bold">Lista de Faturas</h2>

    <!-- Tabela de Faturas -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Total (€)</th>
                <th>Data da Venda</th>
                <th>Método de Pagamento</th>
                <th>Método de Entrega</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($vendas as $fatura): ?>
                <tr>
                    <td><?= Html::encode($fatura->idVenda) ?></td>
                    <td><?= Html::encode(number_format($fatura->total, 2, ',', '.')) ?></td>
                    <td><?= Html::encode(Yii::$app->formatter->asDatetime($fatura->datavenda, 'php:d-m-Y H:i')) ?></td>
                    <td><?= Html::encode($fatura->metodoPagamento->designacao ?? 'Não definido') ?></td>
                    <td><?= Html::encode($fatura->metodoEntrega->designacao ?? 'Não definido') ?></td>
                    <td>
                        <!-- Action Buttons -->
                        <a href="<?= Url::to(['venda/detail-venda', 'id' => $fatura->idVenda]) ?>" class="btn btn-primary btn-sm">Detalhes</a>

                        <a href="<?= Url::to(['venda/pdf', 'id' => $fatura->idVenda]) ?>" class="btn btn-secondary btn-sm">Gerar PDF</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
