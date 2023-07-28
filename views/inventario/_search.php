<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\InventarioSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="inventario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_inventario') ?>

    <?= $form->field($model, 'id_estoque') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'ativo') ?>

    <?php // echo $form->field($model, 'arquivado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
