<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Assinante $model */

$this->title = 'Update Assinante: ' . $model->id_assinante;
$this->params['breadcrumbs'][] = ['label' => 'Assinantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_assinante, 'url' => ['view', 'id_assinante' => $model->id_assinante]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="assinante-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
