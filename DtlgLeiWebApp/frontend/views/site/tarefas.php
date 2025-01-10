<?php
/** @var yii\web\View $this */
/** @var common\models\Tarefa[] $tarefas */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'DL | Tarefas';
$this->params['breadcrumbs'][] = $this->title;
?>
<header>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/styledata.css">
</header>
<div class="container">
    <h2 class="text-center my-4 font-weight-bold">Lista de Tarefas</h2>

    <!-- Tabela de Faturas -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Feito</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tarefas as $tarefa): ?>
                <tr>
                    <td><?= Html::encode($tarefa->idTarefa) ?></td>
                    <td><?= Html::encode($tarefa->descricao) ?></td>
                    <td><?= Html::encode($tarefa->feito, 2, ',', '.') ?></td>
                    <td><?= Html::encode($tarefa->feito ?? 'Não Realizado') ?></td>
                    <select id="categoriaId" name="categoriaId" class="form-control">
                        <option value="">Tarefas</option>
                        <?php foreach ($tarefas as $tarefa): ?>
                            <option value="<?= htmlspecialchars($tarefa->idTarefa, ENT_QUOTES, 'UTF-8') ?>"
                                <?= $tarefa->idTarefa == $selectedTarefaId ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tarefa->feito, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
