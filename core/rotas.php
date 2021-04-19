<?php
//colecao de rotas
$rotas = [
     'inicio' => 'main@index',
     'loja' => 'main@loja',
     'produtos'=>'main@produtos',
     
      //Cliente
     'novo_cliente'=>'main@novo_cliente',
     'criar_cliente'=>'main@criar_cliente',
     'confirmar_email'=>'main@confirmar_email',

      //Login
     'login_submit'=>'main@login_submit',
     'login'=>'main@login',
     'logout'=>'main@logout', 

     //Perfil
     'perfil'=>'main@perfil',
     'alterar_dados_pessoais'=>'main@alterar_dados_pessoais',
     'alterar_dados_pessoais_submit'=>'main@alterar_dados_pessoais_submit',
     'alterar_password'=>'main@alterar_password',
     'alterar_password_submit'=>'main@alterar_password_submit',
     'historico_encomendas'=>'main@historico_encomendas',
     'detalhe_encomenda'=>'main@historico_encomendas_detalhe',

     //Pagamento
     'pagamento' => 'main@pagamento',
          
      //Carrinho
     'remover_produto_carrinho'=>'carrinho@remover_produto_carrinho',
     'adicionar_carrinho'=>'carrinho@adicionar_carrinho',
     'carrinho'=>'carrinho@carrinho',
     'finalizar_encomenda_resumo' => 'carrinho@finalizar_encomenda_resumo',
     'finalizar_encomenda'=>'carrinho@finalizar_encomenda',
     'limpar_carrinho'=> 'carrinho@limpar_carrinho',
     'morada_alternativa'=>'carrinho@morada_alternativa',
     'confirmar_encomenda' => 'carrinho@confirmar_encomenda',
];

//define acao por defeito
$acao = 'inicio';

//verifica se existe a acao na query string
if (isset($_GET['a'])) {
  //verifica se a ação existe nas rotas
  if (!key_exists($_GET['a'], $rotas)) {
    $acao = 'inicio';
  } else {
    $acao = $_GET['a'];
  }
}
//echo 'acao =>' . $acao;
//trata a definição da rota
$partes = explode('@', $rotas[$acao]);
$controlador = 'core\\controllers\\'.ucfirst($partes[0]);
$metodo = $partes[1];

$ctr =new $controlador();
$ctr->$metodo();


