<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Inventario $model */

$this->title = $model->id_inventario;
$this->params['breadcrumbs'][] = ['label' => 'Inventarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inventario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_inventario' => $model->id_inventario], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_inventario' => $model->id_inventario], [
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
            'id_inventario',
            'id_estoque',
            'nome',
            'data',
            'ativo',
            'arquivado',
        ],
    ]) ?>

</div>
