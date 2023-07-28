<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nota".
 *
 * @property int $id_nota
 * @property int $id_usuario
 * @property int $numero
 * @property string $data
 * @property int $processada
 *
 * @property Conferencia[] $conferencias
 * @property ProdutoNota[] $produtoNotas
 * @property Usuario $usuario
 */
class Nota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'numero', 'data_processamento'], 'required'],
            [['id_usuario', 'numero'], 'integer'],
            [['url_arquivo'], 'string', 'max' => 100],
            [['data_processamento'], 'safe'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_nota' => 'Id Nota',
            'id_usuario' => 'Id Usuario',
            'numero' => 'Numero',
            'data' => 'Data',
            'processada' => 'Processada',
        ];
    }

    /**
     * Gets query for [[Conferencias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConferencias()
    {
        return $this->hasMany(Conferencia::class, ['id_nota' => 'id_nota']);
    }

    /**
     * Gets query for [[ProdutoNotas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutoNotas()
    {
        return $this->hasMany(ProdutoNota::class, ['id_nota' => 'id_nota']);
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
