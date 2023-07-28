<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Assinante $model */

$this->title = $model->id_assinante;
$this->params['breadcrumbs'][] = ['label' => 'Assinantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="assinante-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_assinante' => $model->id_assinante], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_assinante' => $model->id_assinante], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_assinante',
            'id_plano',
            'nome',
            'ativo',
        ],
    ]) ?>

</div>
