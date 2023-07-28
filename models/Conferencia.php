<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "conferencia".
 *
 * @property int $id_conferencia
 * @property int $id_nota
 * @property int $id_usuario
 * @property string $data
 *
 * @property Nota $nota
 * @property ProdutoConferencia[] $produtoConferencias
 * @property Usuario $usuario
 */
class Conferencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conferencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nota', 'id_usuario', 'data'], 'required'],
            [['id_nota', 'id_usuario'], 'integer'],
            [['data'], 'safe'],
            [['id_nota'], 'exist', 'skipOnError' => true, 'targetClass' => Nota::class, 'targetAttribute' => ['id_nota' => 'id_nota']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_conferencia' => 'Id Conferencia',
            'id_nota' => 'Id Nota',
            'id_usuario' => 'Id Usuario',
            'data' => 'Data',
        ];
    }

    /**
     * Gets query for [[Nota]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNota()
    {
        return $this->hasOne(Nota::class, ['id_nota' => 'id_nota']);
    }

    /**
     * Gets query for [[ProdutoConferencias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutoConferencias()
    {
        return $this->hasMany(ProdutoConferencia::class, ['id_conferencia' => 'id_conferencia']);
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
