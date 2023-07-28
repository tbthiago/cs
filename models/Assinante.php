<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "assinante".
 *
 * @property int $id_assinante
 * @property int $id_plano
 * @property string $nome
 * @property int $ativo
 *
 * @property Plano $plano
 * @property Usuario[] $usuarios
 */
class Assinante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assinante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_plano', 'nome', 'ativo'], 'required'],
            [['id_plano', 'ativo'], 'integer'],
            [['nome'], 'string', 'max' => 100],
            [['id_plano'], 'exist', 'skipOnError' => true, 'targetClass' => Plano::class, 'targetAttribute' => ['id_plano' => 'id_plano']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_assinante' => 'Id Assinante',
            'id_plano' => 'Id Plano',
            'nome' => 'Nome',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * Gets query for [[Plano]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlano()
    {
        return $this->hasOne(Plano::class, ['id_plano' => 'id_plano']);
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::class, ['id_assinante' => 'id_assinante']);
    }
}
