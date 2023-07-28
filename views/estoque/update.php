<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Estoque $model */

$this->title = 'Update Estoque: ' . $model->id_estoque;
$this->params['breadcrumbs'][] = ['label' => 'Estoques', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_estoque, 'url' => ['view', 'id_estoque' => $model->id_estoque]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estoque-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
