<?php

namespace app\controllers;

use Yii;
use app\containers\BasePublic;
use app\models\Usuario;
use app\models\Assinante;
use app\services\Email;
use yii\helpers\BaseArrayHelper;
use yii\helpers\Url;
use app\helpers\Utils;

class AuthController extends BasePublic
{
    public function actionLogin()
    {
        $params = json_decode(file_get_contents('php://input'), true);

        $login = $params['login'];
        $password = sha1($params['password']);
        $hash = $params['hash'];

        if($hash){
            $model = Usuario::find()
            ->where(['hash' => $hash])
            ->andWhere(['id_tipo_usuario' => [2, 3]])
            ->asArray()->one();

        }
        else{
            $model = Usuario::find()
            ->where(['login' => $login,'senha' => $password])
            ->andWhere(['id_tipo_usuario' => [2, 3]])
            ->asArray()->one();
        }

        if($model){
            if($model['ativo']==1){
                return $model;
            }
            throw new \yii\web\HttpException(403, 'Usuário inativo. Verifique o problema com o suporte.');
        }
        throw new \yii\web\HttpException(401, 'Dados de acesso inválidos, por favor tente novamente');
    }

    public function actionForgotPassword()
    {
        $params = json_decode(file_get_contents('php://input'), true);

        $login = $params['login'];

        if($login){
            $model = Usuario::findOne(['login'=>$login]);
        }

        if ($model) {
            Email::send(
                'fit@nexur.com.br',
                $model->email,
                'Redefinição de Senha',
                [
                    'layout' => 'forgot-password',
                    'params' => [
                        'name' => $model->nome,
                        'hash' => $model->hash 
                    ]
                ],
                'Seu email de redefinição de senha foi enviado com sucesso',
                'Não foi possível enviar o email'
            );
        }

        throw new \yii\web\HttpException(404, 'Erro ao enviar email, por favor verifique se seu email está correto com nosso suporte.');
    }

    public function actionRecoverPassword() 
    { 
        $params = json_decode(file_get_contents('php://input'), true); 
        
        $hash = $params['hash']; 
        $password = $params['password']; 
        
        $model = Usuario::findOne(['hash' => $hash]); 
        
        if ($model) { 
            $model->senha = sha1($password); 
            $model->save(); 
            throw new \yii\web\HttpException(200, 'Senha atualizada com sucesso'); 
        } 
        
        throw new \yii\web\HttpException(404, 'Erro ao atualizar senha, por favor novamente mais tarde');
    } 

    public function actionCheckLogin(){
        $params = json_decode(file_get_contents('php://input'), true);

        $id = $params['id'];
        $login = $params['login'];

        if($id)
            $model = Usuario::find()->where(['login' => $login])->andWhere(['not',['id_usuario'=>$id]])->one();
        else
            $model = Usuario::find()->where(['login' => $login])->one();

        if (!$model) {
            throw new \yii\web\HttpException(200, 'Login disponível');
        }

        throw new \yii\web\HttpException(409, 'Esse login já está sendo utilizado. Escolha outro.');
    }    

}

    
