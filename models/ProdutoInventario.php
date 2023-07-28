<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produto_inventario".
 *
 * @property int $id_produto_inventario
 * @property int $id_inventario
 * @property int $id_produto
 * @property int $caixas
 * @property int $unidades
 *
 * @property Inventario $inventario
 * @property Produto $produto
 */
class ProdutoInventario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto_inventario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_inventario', 'id_produto', 'caixas', 'unidades'], 'required'],
            [['id_inventario', 'id_produto', 'caixas', 'unidades'], 'integer'],
            [['id_inventario'], 'exist', 'skipOnError' => true, 'targetClass' => Inventario::class, 'targetAttribute' => ['id_inventario' => 'id_inventario']],
            [['id_produto'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['id_produto' => 'id_produto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_produto_inventario' => 'Id Produto Inventario',
            'id_inventario' => 'Id Inventario',
            'id_produto' => 'Id Produto',
            'caixas' => 'Caixas',
            'unidades' => 'Unidades',
        ];
    }

    /**
     * Gets query for [[Inventario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInventario()
    {
        return $this->hasOne(Inventario::class, ['id_inventario' => 'id_inventario']);
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
