<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produto_nota".
 *
 * @property int $id_produto_nota
 * @property int $id_nota
 * @property int $id_produto
 * @property int $caixas
 * @property int $unidades
 *
 * @property Nota $nota
 * @property Produto $produto
 */
class ProdutoNota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto_nota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nota', 'id_produto', 'caixas', 'unidades'], 'required'],
            [['id_nota', 'id_produto', 'caixas', 'unidades'], 'integer'],
            [['id_nota'], 'exist', 'skipOnError' => true, 'targetClass' => Nota::class, 'targetAttribute' => ['id_nota' => 'id_nota']],
            [['id_produto'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['id_produto' => 'id_produto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_produto_nota' => 'Id Produto Nota',
            'id_nota' => 'Id Nota',
            'id_produto' => 'Id Produto',
            'caixas' => 'Caixas',
            'unidades' => 'Unidades',
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
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id_produto' => 'id_produto']);
    }
}
