<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Categoria;
use common\models\Fornecedor;
use common\models\Desconto;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Update Produto: ' . $model->idProduto;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idProduto, 'url' => ['view', 'idProduto' => $model->idProduto]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Existing fields -->
    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'preco')->textInput() ?>
    <?= $form->field($model, 'stock')->textInput() ?>
    <?= $form->field($model, 'idCategoria')->dropDownList(\yii\helpers\ArrayHelper::map(Categoria::find()->all(), 'idCategoria', 'designacao'), ['prompt' => 'Selecione uma categoria']) ?>
    <?= $form->field($model, 'fornecedores_idfornecedores')->dropDownList(\yii\helpers\ArrayHelper::map(Fornecedor::find()->all(), 'idfornecedor', 'nome'), ['prompt' => 'Selecione uma fornecedor']) ?>
    <?= $form->field($model, 'idDesconto')->dropDownList(\yii\helpers\ArrayHelper::map(Desconto::find()->all(), 'iddesconto', 'desconto'), ['prompt' => 'Selecione uma desconto (Não é obrigatório)']) ?>

    <!-- Upload new images -->
    <?= $form->field($imagem, 'imagens[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <!-- Display existing images with delete option -->
    <?php if (!empty($imgProduto)): ?>
        <h4>Imagens no produto</h4>
        <div>
            <?php foreach ($imgProduto as $img): ?>
                <div style="display: inline-block; margin: 10px; text-align: center;">
                    <img src="<?= $img->fileName ?>" width="100">
                    <br>
                    <?= Html::a('Delete', ['delete-image', 'idimagem' => $img->idimagem], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this image?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Save Button -->
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
