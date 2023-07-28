<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estoque_usuario".
 *
 * @property int $id_estoque_usuario
 * @property int $id_estoque
 * @property int $id_usuario
 * @property int $ativo
 *
 * @property Estoque $estoque
 * @property Usuario $usuario
 */
class EstoqueUsuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estoque_usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_estoque', 'id_usuario', 'ativo'], 'required'],
            [['id_estoque', 'id_usuario', 'ativo'], 'integer'],
            [['id_estoque'], 'exist', 'skipOnError' => true, 'targetClass' => Estoque::class, 'targetAttribute' => ['id_estoque' => 'id_estoque']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_estoque_usuario' => 'Id Estoque Usuario',
            'id_estoque' => 'Id Estoque',
            'id_usuario' => 'Id Usuario',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * Gets query for [[Estoque]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstoque()
    {
        return $this->hasOne(Estoque::class, ['id_estoque' => 'id_estoque']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id_usuario' => 'id_usuario']);
    }
}
