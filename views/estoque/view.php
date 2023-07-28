<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Estoque $model */

$this->title = $model->id_estoque;
$this->params['breadcrumbs'][] = ['label' => 'Estoques', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="estoque-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_estoque' => $model->id_estoque], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_estoque' => $model->id_estoque], [
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
            'id_estoque',
            'id_usuario',
            'localizacao',
        ],
    ]) ?>

</div>
