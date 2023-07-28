<?php

namespace app\controllers;

use app\containers\BaseSecure;
use app\models\Assinante;
use app\models\Conferencia;
use app\models\Estoque;
use app\models\Inventario;
use app\models\Produto;
use app\models\Nota;
use app\models\Plano;
use app\models\ProdutoInventario;
use app\models\ProdutoConferencia;
use app\models\ProdutoNota;
use yii\web\Controller;
use yii\web\Exception;
use yii\helpers\BaseArrayHelper;

class ApiController extends Controller {
    private $id_usuario=1;
    private $id_assinante=1;

    
    ////////////////////////////////////////////////
    /////////////////  PRODUTOS  ///////////////////
    ////////////////////////////////////////////////
    public function actionProdutos(){
        return json_encode(Produto::find()->where(['ativo'=>1])->asArray()->all());
    }

    ////////////////////////////////////////////////
    ////////////////  ENTRADA NOTA  ////////////////
    ////////////////////////////////////////////////
    public function actionUploadXml(){
        $params = json_decode(file_get_contents('php://input'), true);

        $nota = new Nota();
        // $nota->url_arquivo = sobe pro s3
        $nota->save();
    }

    public function actionNotas(){
        $notas = Nota::find()->where(['id_usuario'=>$this->usuario,'data_processamento'=>null])->asArray()->all();
        return json_encode($notas);
    }

    public function actionNotasProcessadas(){
        //join com conferencia
        $notas = Nota::find()->where(['id_usuario'=>$this->usuario,'data_processamento'=>!null])->asArray()->all();
        return json_encode($notas);
    }

    public function actionProcessa(){
        $params = json_decode(file_get_contents('php://input'), true);

        $notas = $params['notas'];

        $response = array();
        $response['notas'] = array();
        foreach ($notas as $i=>$numero_nota) {
            $response['notas'][$i]['produtos'] = array();
            $nota = Nota::findOne(['numero'=>$numero_nota]);
            $get = file_get_contents($nota->url_arquivo);
            $arr = simplexml_load_string($get);
            foreach ($arr->NFe->infNFe->det as $j=>$line) {
                $response['notas'][$i]['produtos'][$j] = Produto::find()->where(['codigo'=>$line->prod->cProd,'ativo'=>1])->asArray()->one();
                // echo $line->prod->cProd.' '.$line->prod->xProd.' '.$line->prod->qCom.'<br>';
            }
            $nota->data_processamento = date('Y-m-d');
            $nota->save();
        }
        return json_encode($response);
    }

    public function actionSalvaConferencia(){

    }


    ////////////////////////////////////////////////
    ////////////////  INVENTÁRIOS  /////////////////
    ////////////////////////////////////////////////
    public function actionInventarios(){
        $inventarios = Inventario::find()
                        ->joinWith(['produtoInventarios'=>function($q) {
                            $q->joinWith(['produto']);
                        }])
                        ->joinWith(['usuario'=>function($q) {
                            $q->joinWith(['assinante'])
                            ->where(['assinante.id_assinante'=>$this->id_assinante]);
                        }])
                        ->asArray()->all();

        return json_encode($inventarios);
    }

    public function actionInventario($id){
        $inventarios = Inventario::find()
                        ->joinWith(['produtoInventarios'=>function($q) {
                            $q->joinWith(['produto']);
                        }])
                        ->joinWith(['usuario'=>function($q) {
                            $q->joinWith(['assinante'])
                            ->where(['assinante.id_assinante'=>$this->id_assinante]);
                        }])
                        ->where(['id_inventario'=>$id])
                        ->asArray()->all();

        return json_encode($inventario);
    }

    public function actionSalvarInventario($id = null){
        $params = json_decode(file_get_contents('php://input'), true);

        if($id){
            $inventario = Inventario::findOne($id);
            if(!$inventario)
                throw new \yii\web\HttpException(404, 'Inventário não encontrado');
        }
        else
            $inventario = new Inventario();

        $inventario->nome = $params['nome'];
        $inventario->data = $params['data'];
        $inventario->ativo = 1;
        $inventario->arquivado = 0;
        if($inventario->save()){
            if(is_array($produtos)){
                ProdutoInventario::deleteAll(['id_inventario'=>$inventario->id_inventario]);
                foreach ($params['produtos'] as $produto) {
                    $produto_inventario = new ProdutoInventario();
                    $produto_inventario->id_inventario = $inventario->id_inventario;
                    $produto_inventario->id_produto = $produto['id_produto'];
                    $produto_inventario->caixas = $produto['caixas'];
                    $produto_inventario->unidades = $produto['unidades'];
                    $produto_inventario->save();
                }
            }
            return $this->actionInventario($inventario->id_inventario);
        }
        throw new \yii\web\HttpException(409, 'Erro ao salvar inventário');
    }

    public function actionArquivarInventario($id){
        $inventario = Inventario::findOne($id);
        if($inventario){
            $inventario->arquivado=1;
            $inventario->save();
            return json_encode(BaseArrayHelper::toArray($inventario));
        }
        throw new \yii\web\HttpException(404, 'Inventário não encontrado');
    }

    public function actionApagarInventario($id){
        $inventario = Inventario::findOne($id);
        if($inventario){
            $inventario->ativo=1;
            $inventario->save();
            return json_encode(BaseArrayHelper::toArray($inventario));
        }
        throw new \yii\web\HttpException(404, 'Inventário não encontrado');
    }


    ////////////////////////////////////////////////
    //////////////////  ESTOQUES  //////////////////
    ////////////////////////////////////////////////
    public function actionEstoques(){
        return json_encode(Estoque::find()->joinWith('estoqueUsuarios')->where(['estoque_usuario.ativo'=>1,'estoque_usuario.id_usuario'=>$this->id_usuario])->asArray()->all());
    }

    public function actionSalvarEstoque($id = null){
        $params = json_decode(file_get_contents('php://input'), true);

        $nome = $params['nome'];
        $localizacao = $params['email'];
        $inventariantes = $params['inventariantes']; //somente id_usuarios

        if($id){
            $estoque = Estoque::find()
                        ->joinWith('estoqueUsuarios')
                        ->where(['estoque.id_estoque'=>$id])->one();
            $estoque->nome = $nome;
            $estoque->localizacao = $localizacao;

            $usuario = Usuario::findOne($estoque->id_usuario);
            if($usuario->id_assainnte!=$this->assinante){
                throw new \yii\web\HttpException(403, 'Você não tem permissão pra alterar esse estoque');
            }
            
            $usuarios_estoque = array_cloumn(BaseArrayHelper::toArray($estoque->estoqueUsuarios),'id_usuario');
            $news = array_diff($inventariantes,$usuarios_estoque);
            if(!empty($news)){
                foreach ($news as $new) {
                    $usuario_estoque = new UsuarioEstoque();
                    $usuario_estoque->id_usuario = $new;
                    $usuario_estoque->id_estoque = $id;
                    $usuario_estoque->ativo = 1;
                    $usuario_estoque->save();
                }
            }
            $olds = array_diff($usuarios_estoque,$inventariantes);
            if(!empty($olds)){
                foreach ($olds as $old) {
                    $usuario_estoque = UsuarioEstoque::findOne($old);
                    $usuario_estoque->ativo = 0;
                    $usuario_estoque->save();
                }
            }
        }
        else {
            $estoque = new Estoque();
            $estoque->nome = $nome;
            $estoque->localizacao = $localizacao;
            foreach ($inventariantes as $inventariante) {
                $usuario_estoque = new UsuarioEstoque();
                $usuario_estoque->id_usuario = $inventariante;
                $usuario_estoque->id_estoque = $id;
                $usuario_estoque->ativo = 1;
                $usuario_estoque->save();
            }
        }
        if($estoque->save())
            return json_encode(BaseArrayHelper::toArray($inventario));

        throw new \yii\web\HttpException(409, 'Erro ao salvar estoque');
    }

    public function actionApagarEstoque($id){
        $estoque = Estoque::findOne($id);
        if($estoque){
            $estoque->ativo=0;
            $estoque->save();
            return json_encode(BaseArrayHelper::toArray($estoque));
        }
        throw new \yii\web\HttpException(404, 'Usuário não encontrado');
    }

    ////////////////////////////////////////////////
    ///////////////  INVENTARIANTES  ///////////////
    ////////////////////////////////////////////////
    public function actionUsuarios(){
        return json_encode(Usuario::find()->where(['id_assinante'=>$this->id_assinante])->asArray()->all());
    }

    public function actionSalvarUsuario($id = null){
        $params = json_decode(file_get_contents('php://input'), true);

        if($id){
            $usuario = Usuario::find()->where(['id_usuario'=>$id,'id_assiannte'=>$this->assinante])->one();
            if(!$usuario)
                throw new \yii\web\HttpException(404, 'Usuário não encontrado');
        }
        else
            $usuario = new Usuario();

        $usuario->nome = $params['nome'];
        $usuario->email = $params['email'];
        $usuario->login = $params['login'];
        $usuario->senha = $params['senha'];
        $usuario->hash = Utils::hash($login);;
        $usuario->ativo = 1;
        $usuario->id_assinante = $this->assinante;
        $usuario->id_tipo_usuario=3;

        if($usuario->save())
            return json_encode(BaseArrayHelper::toArray($usuario));

        throw new \yii\web\HttpException(409, 'Erro ao cadastrar usuário');
    }

    public function actionApagarUsuario($id){
        $usuario = Usuario::findOne($id);
        if($usuario){
            $usuario->ativo=0;
            $usuario->save();
            return json_encode(BaseArrayHelper::toArray($usuario));
        }
        throw new \yii\web\HttpException(404, 'Usuário não encontrado');
    }


}
