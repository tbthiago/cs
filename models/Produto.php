<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produto".
 *
 * @property int $id_produto
 * @property string|null $codigo
 * @property string|null $nome
 * @property string|null $url_foto
 * @property int|null $ativo
 *
 * @property ProdutoInventario[] $produtoInventarios
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ativo'], 'integer'],
            [['codigo', 'nome'], 'string', 'max' => 100],
            [['url_foto'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_produto' => 'Id Produto',
            'codigo' => 'Codigo',
            'nome' => 'Nome',
            'url_foto' => 'Url Foto',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * Gets query for [[ProdutoInventarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutoInventarios()
    {
        return $this->hasMany(ProdutoInventario::class, ['id_produto' => 'id_produto']);
    }
}
