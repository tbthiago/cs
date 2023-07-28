<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Inventario $model */

$this->title = 'Update Inventario: ' . $model->id_inventario;
$this->params['breadcrumbs'][] = ['label' => 'Inventarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_inventario, 'url' => ['view', 'id_inventario' => $model->id_inventario]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inventario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
