<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Categoria;
use common\models\Fornecedor;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preco')->textInput() ?>

    <?= $form->field($model, 'stock')->textInput() ?>

    <?= $form->field($model, 'idCategoria')->dropDownList(\yii\helpers\ArrayHelper::map(Categoria::find()->all(), 'idCategoria', 'designacao'), ['prompt' => 'Selecione uma categoria']) ?>

    <?= $form->field($model, 'fornecedores_idfornecedores')->dropDownList(\yii\helpers\ArrayHelper::map(Fornecedor::find()->all(), 'idfornecedor', 'nome'), ['prompt' => 'Selecione uma fornecedor']) ?>

    <?= $form->field($imagem, 'imagens[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
