<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produto_conferencia".
 *
 * @property int $id_produto_conferencia
 * @property int $id_conferencia
 * @property int $id_produto
 * @property int $caixas
 *
 * @property Conferencia $conferencia
 * @property Produto $produto
 */
class ProdutoConferencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto_conferencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_conferencia', 'id_produto', 'caixas'], 'required'],
            [['id_conferencia', 'id_produto', 'caixas'], 'integer'],
            [['id_conferencia'], 'exist', 'skipOnError' => true, 'targetClass' => Conferencia::class, 'targetAttribute' => ['id_conferencia' => 'id_conferencia']],
            [['id_produto'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['id_produto' => 'id_produto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_produto_conferencia' => 'Id Produto Conferencia',
            'id_conferencia' => 'Id Conferencia',
            'id_produto' => 'Id Produto',
            'caixas' => 'Caixas',
        ];
    }

    /**
     * Gets query for [[Conferencia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConferencia()
    {
        return $this->hasOne(Conferencia::class, ['id_conferencia' => 'id_conferencia']);
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id_produto' => 'id_produto']);
    }
}
