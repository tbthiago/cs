<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Produto $model */

$this->title = 'Update Produto: ' . $model->id_produto;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_produto, 'url' => ['view', 'id_produto' => $model->id_produto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="produto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
