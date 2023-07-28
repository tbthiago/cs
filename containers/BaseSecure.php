<?php

namespace app\containers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\Cors;
use app\models\Usuario;
use app\models\Log;

class BaseSecure extends Controller
{
    public function init()
    {
      parent::init();
      Yii::$app->response->format = Response::FORMAT_JSON;
      $this->enableCsrfValidation = false;
      $this->layout = false;
    }

    public function behaviors()
    {
      return [
        'corsFilter' => [
          'class' => Cors::className(),
          'cors' => [
            'Origin' => ['*'],
            'Access-Control-Request-Headers' => ['Content-Type', 'Authorization'],
            'Access-Control-Allow-Headers' => ['Content-Type', 'Authorization']
          ]
        ]
      ];
    }

    public function beforeAction($action) {
      header('Access-Control-Allow-Origin: *'); 
      header("Access-Control-Allow-Credentials: true");
      header('Access-Control-Allow-Methods: GET, PUT, PATCH, POST, DELETE, OPTIONS');
      header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

      if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
        return false;
      }
      
      $headers = Yii::$app->request->headers;
      $Authorization = $headers->get('Authorization');
      $hash = explode(' ', $Authorization)[1];

      if ($hash) {
        $model = Usuario::findOne(['hash' => $hash]);
      }

      if($model){
        if($model->id_tipo_usuario==2 || $model->id_tipo_usuario==3){
          if ($model->ativo==1) {
            Yii::$app->user->login($model, true);
            return true;
          }
          else throw new \yii\web\HttpException(401, 'Usuário inativo. Verifique o problema com o suporte.');          
        }
      }
      throw new \yii\web\HttpException(401, 'Dados de acesso inválidos, por favor tente novamente.');
    
      return parent::beforeAction($action);
    }

    //INSERIR EVENTO NA TABELA LOG
    public function afterAction($action, $result) {

    }
}
