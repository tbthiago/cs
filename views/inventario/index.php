<?php

use app\models\Inventario;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\InventarioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Inventarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Inventario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_inventario',
            'id_estoque',
            'nome',
            'data',
            'ativo',
            //'arquivado',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Inventario $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_inventario' => $model->id_inventario]);
                 }
            ],
        ],
    ]); ?>


</div>
