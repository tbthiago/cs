<?php

use app\models\Estoque;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\EstoqueSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Estoques';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estoque-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Estoque', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_estoque',
            'id_usuario',
            'localizacao',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Estoque $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_estoque' => $model->id_estoque]);
                 }
            ],
        ],
    ]); ?>


</div>
