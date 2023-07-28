<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Assinante $model */

$this->title = 'Create Assinante';
$this->params['breadcrumbs'][] = ['label' => 'Assinantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assinante-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
