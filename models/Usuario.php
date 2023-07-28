<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

class Usuario extends ActiveRecord implements IdentityInterface
{   
    public $id;
    public $username;
    public $password;
    public $auth_key;
    public $accessToken;
    public $password_hash;
    public $password_reset_token;
    
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'email', 'login', 'senha', 'hash', 'ativo', 'id_assinante', 'id_tipo_usuario'], 'required'],
            [['ativo', 'id_assinante', 'id_tipo_usuario'], 'integer'],
            [['nome'], 'string', 'max' => 200],
            [['email', 'login', 'senha', 'hash'], 'string', 'max' => 100],
            [['id_assinante'], 'exist', 'skipOnError' => true, 'targetClass' => Assinante::class, 'targetAttribute' => ['id_assinante' => 'id_assinante']],
            [['id_tipo_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => TipoUsuario::class, 'targetAttribute' => ['id_tipo_usuario' => 'id_tipo_usuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'nome' => 'Nome',
            'email' => 'Email',
            'login' => 'Login',
            'senha' => 'Senha',
            'hash' => 'Hash',
            'ativo' => 'Ativo',
            'id_assinante' => 'Id Assinante',
            'id_tipo_usuario' => 'Id Tipo Usuario',
        ];
    }

    /**
     * Gets query for [[Assinante]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssinante()
    {
        return $this->hasOne(Assinante::class, ['id_assinante' => 'id_assinante']);
    }

    /**
     * Gets query for [[Estoques]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstoques()
    {
        return $this->hasMany(Estoque::class, ['id_usuario' => 'id_usuario']);
    }

    /**
     * Gets query for [[TipoUsuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoUsuario()
    {
        return $this->hasOne(TipoUsuario::class, ['id_tipo_usuario' => 'id_tipo_usuario']);
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username) {
        return static::findOne(['login' => $username]);
    }

    public static function findByPasswordResetToken($token) {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }
    public function validatePassword($password) {
        return $this->senha === sha1($password);
    }

    public function setPassword($password) {
        $this->password_hash = Security::generatePasswordHash($password);
    }

    public function generateAuthKey() {
        $this->auth_key = Security::generateRandomKey();
    }

    public function generatePasswordResetToken() {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }    
}
