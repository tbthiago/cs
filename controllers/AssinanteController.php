<?php

namespace app\controllers;

use app\models\Assinante;
use app\models\AssinanteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AssinanteController implements the CRUD actions for Assinante model.
 */
class AssinanteController extends Controller
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
     * Lists all Assinante models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AssinanteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Assinante model.
     * @param int $id_assinante Id Assinante
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_assinante)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_assinante),
        ]);
    }

    /**
     * Creates a new Assinante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Assinante();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_assinante' => $model->id_assinante]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Assinante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_assinante Id Assinante
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_assinante)
    {
        $model = $this->findModel($id_assinante);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_assinante' => $model->id_assinante]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Assinante model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_assinante Id Assinante
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_assinante)
    {
        $this->findModel($id_assinante)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Assinante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_assinante Id Assinante
     * @return Assinante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_assinante)
    {
        if (($model = Assinante::findOne(['id_assinante' => $id_assinante])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
