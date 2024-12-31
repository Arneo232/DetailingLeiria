<?php
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\Avaliacao $reviewModel */
/** @var int $idProduto */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="review-form">
    <?php $form = ActiveForm::begin([
        'action' => ['avaliacao/fazer-avaliacao', 'idProduto' => $idProduto],
        'method' => 'post',
    ]); ?>

    <?= $form->field($reviewModel, 'rating')->dropDownList([1, 2, 3, 4, 5], ['prompt' => 'Selecione uma avaliação']) ?>
    <?= $form->field($reviewModel, 'comentario')->textarea(['rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submeter Avaliação', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
