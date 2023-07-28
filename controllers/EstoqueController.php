<?php

namespace app\controllers;

use app\models\Estoque;
use app\models\EstoqueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EstoqueController implements the CRUD actions for Estoque model.
 */
class EstoqueController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Estoque models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EstoqueSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Estoque model.
     * @param int $id_estoque Id Estoque
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_estoque)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_estoque),
        ]);
    }

    /**
     * Creates a new Estoque model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Estoque();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_estoque' => $model->id_estoque]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Estoque model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_estoque Id Estoque
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_estoque)
    {
        $model = $this->findModel($id_estoque);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_estoque' => $model->id_estoque]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Estoque model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_estoque Id Estoque
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_estoque)
    {
        $this->findModel($id_estoque)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Estoque model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_estoque Id Estoque
     * @return Estoque the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_estoque)
    {
        if (($model = Estoque::findOne(['id_estoque' => $id_estoque])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
