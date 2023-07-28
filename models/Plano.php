<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plano".
 *
 * @property int $id_plano
 * @property string $nome
 * @property int $num_estoques
 *
 * @property Assinante[] $assinantes
 */
class Plano extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plano';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'num_estoques'], 'required'],
            [['num_estoques'], 'integer'],
            [['nome'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_plano' => 'Id Plano',
            'nome' => 'Nome',
            'num_estoques' => 'Num Estoques',
        ];
    }

    /**
     * Gets query for [[Assinantes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssinantes()
    {
        return $this->hasMany(Assinante::class, ['id_plano' => 'id_plano']);
    }
}
