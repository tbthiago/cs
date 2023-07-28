<?php

use app\models\Assinante;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AssinanteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Assinantes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assinante-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Assinante', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_assinante',
            'id_plano',
            'nome',
            'ativo',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Assinante $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_assinante' => $model->id_assinante]);
                 }
            ],
        ],
    ]); ?>


</div>
