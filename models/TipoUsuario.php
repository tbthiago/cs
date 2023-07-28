<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_usuario".
 *
 * @property int $id_tipo_usuario
 * @property string $nome
 *
 * @property Usuario[] $usuarios
 */
class TipoUsuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_usuario' => 'Id Tipo Usuario',
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::class, ['id_tipo_usuario' => 'id_tipo_usuario']);
    }
}
