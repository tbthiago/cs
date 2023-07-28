<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventario".
 *
 * @property int $id_inventario
 * @property int $id_estoque
 * @property string $nome
 * @property string $data
 * @property int $ativo
 * @property int $arquivado
 *
 * @property Estoque $estoque
 * @property ProdutoInventario[] $produtoInventarios
 */
class Inventario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_estoque', 'nome', 'data', 'ativo', 'arquivado'], 'required'],
            [['id_estoque', 'ativo', 'arquivado'], 'integer'],
            [['data'], 'safe'],
            [['nome'], 'string', 'max' => 100],
            [['id_estoque'], 'exist', 'skipOnError' => true, 'targetClass' => Estoque::class, 'targetAttribute' => ['id_estoque' => 'id_estoque']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_inventario' => 'Id Inventario',
            'id_estoque' => 'Id Estoque',
            'nome' => 'Nome',
            'data' => 'Data',
            'ativo' => 'Ativo',
            'arquivado' => 'Arquivado',
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

    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id_usuario' => 'id_usuario']);
    }
    /**
     * Gets query for [[ProdutoInventarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutoInventarios()
    {
        return $this->hasMany(ProdutoInventario::class, ['id_inventario' => 'id_inventario']);
    }
}
