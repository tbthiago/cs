<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estoque".
 *
 * @property int $id_estoque
 * @property string $nome
 * @property string $localizacao
 * @property int $ativo
 *
 * @property EstoqueUsuario[] $estoqueUsuarios
 * @property Inventario[] $inventarios
 */
class Estoque extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estoque';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'localizacao', 'ativo'], 'required'],
            [['ativo'], 'integer'],
            [['nome'], 'string', 'max' => 100],
            [['localizacao'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_estoque' => 'Id Estoque',
            'nome' => 'Nome',
            'localizacao' => 'Localizacao',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * Gets query for [[EstoqueUsuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstoqueUsuarios()
    {
        return $this->hasMany(EstoqueUsuario::class, ['id_estoque' => 'id_estoque']);
    }

    /**
     * Gets query for [[Inventarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInventarios()
    {
        return $this->hasMany(Inventario::class, ['id_estoque' => 'id_estoque']);
    }
}
