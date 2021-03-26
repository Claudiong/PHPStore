<?php


namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Encomendas;
use core\models\Produtos;

class carrinho
{

    public function carrinho()
    {

        $dados_tmp = [];

        if ((!isset($_SESSION['carrinho'])) || count($_SESSION['carrinho']) == 0) {
            $dados = ['carrinho' => null];
        } else {

            $ids = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                array_push($ids, $id_produto);
            }
            $ids = implode(",", $ids);
            $produtos = new produtos();
            $resultados = $produtos->buscar_produtos_por_ids($ids);
            $preco_total = 0;

            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {

                foreach ($resultados as $produto) {

                    if ($id_produto == $produto->id_produto) {
                        $id_produto = $produto->id_produto;
                        $imagem = $produto->imagem;
                        $titulo = $produto->nome_produto;
                        $quantidade = $quantidade_carrinho;
                        $preco = $produto->preco * $quantidade_carrinho;
                        array_push($dados_tmp, [
                            'id_produto' => $id_produto,
                            'imagem' => $imagem,
                            'titulo' => $titulo,
                            'quantidade' => $quantidade,
                            'preco' => $preco
                        ]);
                        $preco_total += $preco;
                    }
                }
            }
            array_push($dados_tmp, $preco_total);
            $dados = [
                'carrinho' => $dados_tmp
            ];
        }



        // store::printdata($dados_tmp);




        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'carrinho',
            'layouts/footer',
            'layouts/html_footer',
        ], $dados);
    }


    public function adicionar_carrinho()
    {



        if (!isset($_GET['id_produto'])) {

            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : ' ';

            return;
        }

        $id_produto = $_GET['id_produto'];

        $produtos = new Produtos();
        $resultado = $produtos->verificar_stock_produto($id_produto);

        if (!$resultado) {
            header('location:' . BASE_URL . 'index.php?a=loja');
            return;
        }

        $carrinho = [];

        if (isset($_SESSION['carrinho'])) {


            $carrinho = $_SESSION['carrinho'];
        }

        if (key_exists($id_produto, $carrinho)) {
            $carrinho[$id_produto]++;
        } else {

            $carrinho[$id_produto] = 1;
        }

        $_SESSION['carrinho'] = $carrinho;
        $total_produtos = 0;


        foreach ($carrinho as $produto_quantidade) {
            $total_produtos += $produto_quantidade;
        }
        echo $total_produtos;
    }

    public function limpar_carrinho()
    {

        unset($_SESSION['carrinho']);
        $this->carrinho();
    }


    public function remover_produto_carrinho()
    {

        $id_produto = $_GET['id_produto'];
        $carrinho = $_SESSION['carrinho'];
        unset($carrinho[$id_produto]);
        $_SESSION['carrinho'] = $carrinho;
        $this->carrinho();
    }

    public function finalizar_encomenda()
    {
        // store::printdata($_SESSION);
        if (!Store::clienteLogado()) {
            $_SESSION['tmp_carrinho'] = 1;
            Store::redirect('login');
        } else {
            Store::redirect('finalizar_encomenda_resumo');
        }
    }


    public function finalizar_encomenda_resumo()
    {
        $dados_tmp = [];
        if (!isset($_SESSION['cliente'])) {
            store::redirect('inicio');
        }


        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho'])==0){
            store::redirect('inicio');
            return;
        }

        $ids = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
            array_push($ids, $id_produto);
        }

        $ids = implode(",", $ids);
        $produtos = new produtos();
        $resultados = $produtos->buscar_produtos_por_ids($ids);
        $preco_total = 0;



        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {

            foreach ($resultados as $produto) {

                if ($id_produto == $produto->id_produto) {
                    $id_produto = $produto->id_produto;
                    $imagem = $produto->imagem;
                    $titulo = $produto->nome_produto;
                    $quantidade = $quantidade_carrinho;
                    $preco = $produto->preco * $quantidade_carrinho;
                    array_push($dados_tmp, [
                        'id_produto' => $id_produto,
                        'imagem' => $imagem,
                        'titulo' => $titulo,
                        'quantidade' => $quantidade,
                        'preco' => $preco
                    ]);
                    $preco_total += $preco;
                }
            }
        }
        

        array_push($dados_tmp, $preco_total);

        $dados = [];
        $dados['carrinho'] = $dados_tmp;

        $dados = [
            'carrinho' => $dados_tmp
        ];

        $cliente = new Clientes();
        $dados_cliente = $cliente->buscar_dados_cliente($_SESSION['cliente']);


        if (!isset($_SESSION['codigo_encomenda'])) {
            $codigo_encomenda=store::gerarCodigoEncomenda();           
            $dados['codigo_encomenda']=$codigo_encomenda;            
            $_SESSION['codigo_encomenda']=$codigo_encomenda;
        }

        $dados['cliente'] = $dados_cliente;
        $_SESSION['total_encomenda'] =  $preco_total;
    
        

       
        Store::layout([
            'layouts/html_header',
            'layouts/header',
            'encomenda_resumo',
            'layouts/footer',
            'layouts/html_footer',
        ], $dados);
    }



   

    public function morada_alternativa()
    {

        echo 'ok teste';

        $post = json_decode(file_get_contents('php://input'), true);
        $_SESSION['dados_alternativos'] = [
            'morada' => $post['text_morada'],
            'teste' => 'claudiiiiiiio',
            'cidade' => $post['text_cidade'],
            'email' => $post['text_email'],
            'telefone' => $post['text_telefone'],
        ];
    }


    public function confirmar_encomenda()
    {

        if (!isset($_SESSION['cliente'])) {
            store::redirect('inicio');
            return;
        }


        if (!isset($_SESSION['carrinho']) ){
            store::redirect('inicio');
            return;
        }

       
        

        $dados_encomenda = [];
        //listar os dados dos produtos;
        $ids = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
          array_push($ids, $id_produto);
        }
        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $produtos_da_encomenda = $produtos ->buscar_produtos_por_ids($ids);
        $string_produtos = [];



        foreach ($produtos_da_encomenda as $resultado) {
            
            $quantidade = $_SESSION['carrinho'][$resultado->id_produto];
            $string_produtos[]="$quantidade x $resultado->nome_produto -" . number_format($resultado->preco,2,',','.') . "/Unid";


        };



       $dados_encomenda['lista_produtos'] = $string_produtos; 
       $dados_encomenda['total'] = $_SESSION['total_encomenda'];

       $dados_encomenda['dados_pagamento'] = [
           'conta'=>'9999999',
           'codigo_encomenda'=> $_SESSION['codigo_encomenda'],
           'total'=>number_format($_SESSION['total_encomenda'],2,',','.'),      
       
       ];
       
       $email = new EnviarEmail();
       $resultado = $email->enviar_email_confirmacao_encomenda($_SESSION['usuario'],$dados_encomenda);

       
       $dados_encomenda = [];
       $dados_encomenda['id_cliente'] =$_SESSION['cliente'];
       if (isset($_SESSION['dados_alternativod']['morada']) && !empty($_SESSION['dados_alternativod']['morada'])) { 
          $dados_encomenda['morada'] = $_SESSION['dados_alternativos']['morada'];
          $dados_encomenda['cidade'] = $_SESSION['dados_alternativos']['cidade'];
          $dados_encomenda['email'] = $_SESSION['dados_alternativos']['email'];
          $dados_encomenda['telefone'] = $_SESSION['dados_alternativos']['telefone'];
       } else {
          $cliente = new  Clientes();            
          $dados_cliente = $cliente -> buscar_dados_cliente($_SESSION['cliente']);   
          $dados_encomenda['morada'] = $dados_cliente->morada;
          $dados_encomenda['cidade'] = $dados_cliente->cidade;
          $dados_encomenda['email'] = $dados_cliente->email;
          $dados_encomenda['telefone'] = $dados_cliente->telefone;
       }  

       
       $dados_encomenda['codigo_encomenda'] = $_SESSION['codigo_encomenda'];
       $dados_encomenda['status'] = 'PENDENTE';
       $dados_encomenda['mensagem'] = '';

       

       $dados_produtos=[];

       foreach ($produtos_da_encomenda as $produto) {
           $dados_produto[]= [
            'designacao_produto'=>$produto->nome_produto,
            'preco_unidade'=>$produto->preco,
            'quantidade'=>$_SESSION['carrinho'][$produto->id_produto],
           ];
       }  
       


       $encomenda = new Encomendas();
       $encomenda->guardar_encomenda($dados_encomenda, $dados_produto);



        // //  echo 'finaloizar encomenda';
        // //  store::printdata($_SESSION);
         $codigo_encomenda = $_SESSION['codigo_encomenda'];
         $total_encomenda = $_SESSION['total_encomenda'];
         $dados=[
             'codigo_encomenda'=>$codigo_encomenda,
             'total_encomenda'=>$total_encomenda            
         ];
          unset($_SESSION['codigo_encomenda']);           
          unset($_SESSION['carrinho']);           
          unset($_SESSION['total_encomenda']);           
          unset($_SESSION['dados_alternativos']);       
          
          
        //   Store::printdata($_SESSION);



         Store::layout([
             'layouts/html_header',
             'layouts/header',
             'encomenda_confirmada',
             'layouts/footer',
             'layouts/html_footer',
         ], $dados);
    }
}
