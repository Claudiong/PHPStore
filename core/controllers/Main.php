<?php
namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Produtos;

class Main {

   public function index() {
          
      

      Store::layout([
      'layouts/html_header',
      'layouts/header',
      'inicio',
      'layouts/footer',
      'layouts/html_footer',]);
   }

   public function loja() {
    //apresenta a pagina da loja 
       $produtos = new Produtos();
       $c =''; 
       if (isset($_GET['c'])) {
          $c = $_GET['c'];     

       }
       $lista_produtos = $produtos->lista_produtos_disponiveis($c);
       $lista_categorias = $produtos->lista_categorias();
       
       $dados = ['produtos'=>$lista_produtos, 'categorias'=>$lista_categorias];
       
       Store::layout([
       'layouts/html_header',
       'layouts/header',
       'loja',
       'layouts/footer',
       'layouts/html_footer',],
        $dados);


   }

   public function novo_cliente() {

    if (store::clienteLogado()) {
      $this->index();
      return;
    }
    
    Store::layout([
      'layouts/html_header',
      'layouts/header',
      'criar_cliente',
      'layouts/footer',
      'layouts/html_footer',]);


   }

   public function Login() {

      if (store::clienteLogado()){       
         store::redirect();
         return;

       }
    
    
      Store::layout([
         'layouts/html_header',
         'layouts/header',
         'login_frm',
         'layouts/footer',
         'layouts/html_footer',]);
  
   }
   
  


   public function criar_cliente(){
     
        if (store::clienteLogado()) {
          $this->index();
          return;
        }

        if ($_SERVER['REQUEST_METHOD'] != 'POST'){
           $this->index();
           return;
        }
 
        if ($_POST['text_senha_1'] !== $_POST['text_senha_2']) {
          $_SESSION['erro'] = 'As senhas estão diferentes';
          $this->novo_cliente();
          return;
         }

         $cliente = new clientes();
         if ($cliente->verificar_email_existe($_POST['text_email'])) {

            $_SESSION['erro'] = 'Já existe cliente com este email';
            $this ->novo_cliente();
            return;
         }
         $email_cliente = strtolower(trim($_POST['text_email']));
         $purl = $cliente ->registrar_cliente();        

         //envio do email pro cliente
         $email = new EnviarEmail();
        
         $resultado = $email->enviar_email_confirmacao_novo_cliente($email_cliente, $purl);
         if ($resultado) {
            Store::layout([
               'layouts/html_header',
               'layouts/header',
               'criar_cliente_sucesso',
               'layouts/footer',
               'layouts/html_footer',]);
               return;
         } else {
            echo 'erro ao enviar email';
         }      
   }

   
   public function confirmar_email(){
      if (store::clienteLogado()) {
         $this->index();
         return;
      }   
      if (!isset($_GET['purl'])) {
         $this->index();
         return;
      }

      if (strlen($_GET['purl'])!=12) {
         $this->index();
         return;

      }

      echo 'aqui';
      $cliente = new Clientes();
      $resultado=$cliente->validar_email(($_GET['purl']));

      if ($resultado) {
         Store::layout([
            'layouts/html_header',
            'layouts/header',
            'conta_confirmada_sucesso',
            'layouts/footer',
            'layouts/html_footer',]);
            return;
      } else {
         store::redirect('');
      }
   }   


   public function login_submit () {

      
      if (store::clienteLogado()){
         
         store::redirect();
         return;

       } 

       if ($_SERVER['REQUEST_METHOD']!='POST') {
         Store::redirect();
         return;
       }
      
       if (
         !isset($_POST['text_usuario']) ||
         !isset($_POST['text_senha']) ||
         !filter_var(trim($_POST['text_usuario']), FILTER_VALIDATE_EMAIL)
         ) {
            $_SESSION['erro']='Login inválido';
            store::redirect('Login');
            return;
         }
         $usuario=trim(strtolower($_POST['text_usuario']));
         $senha=trim($_POST['text_senha']);
  
         $cliente = new Clientes();
         $resultado=$cliente->validar_login($usuario, $senha);
         print_r($resultado);
         if (is_bool($resultado)) {
            $_SESSION['erro']='Login Inválido';
            store::redirect('login');
            return;
         } else {
            $_SESSION['cliente']=$resultado->id_cliente;
            $_SESSION['usuario']=$resultado->email;
            $_SESSION['nome_cliente']=$resultado->nome_completo;
            if (isset($_SESSION['tmp_carrinho'])) {
               store::redirect('finalizar_encomenda_resumo');
               unset($_SESSION['tmp_carrinho']);

            } 
            else {
            store::redirect();
            }
         }

         
   }

   public function logout() {


      unset($_SESSION['cliente']);  
      unset($_SESSION['usuario']); 
      unset($_SESSION['nome_cliente']);
    store::redirect();  
   }      

   public function perfil() {

      if (!Store::clienteLogado()) {
         Store::redirect();
         return;
      }

      $cliente = new Clientes();      
      $dtemp = $cliente->buscar_dados_cliente($_SESSION['cliente']);
      $dados_cliente = [
      'email' => $dtemp->email,
      'Nome Completo' => $dtemp->nome_completo,
      'Endereço' => $dtemp->morada,
      'Cidade' => $dtemp->cidade,
      'telefone' => $dtemp->telefone,
      ];

      $dados = [
       'dados_cliente' => $dados_cliente
      ];



      Store::layout([
            'layouts/html_header',
            'layouts/header',
            'perfil_navegacao',
            'perfil',            
            'layouts/footer',
            'layouts/html_footer',],$dados);



      } 
       

      public function alterar_dados_pessoais() {

         if (!store::clienteLogado()) {
            store::redirect();
            return;
         }


         // $erro = '';
         // if (isset($_SESSION['erro'])) {
         //    $erro = $_SESSION['erro'];
         //    unset($_SESSION['erro']);

         // }

         $cliente = new Clientes();      
          


         $dados= [
            'dados_pessoais' =>$cliente->buscar_dados_cliente($_SESSION['cliente'])
         ];


         // if (!empty($erro) ) {
         //    $dados['erro'] = $erro;
         // }

         Store::layout([
            'layouts/html_header',
            'layouts/header',
            'perfil_navegacao',
            'alterar_dados_pessoais',            
            'layouts/footer',
            'layouts/html_footer',],$dados);



      }
      

      public function alterar_dados_pessoais_submit() {
         echo 'alterar dados pessoais submit';
         
         
         
         
         if (!store::clienteLogado()) {
            store::redirect();
            return;
         }
         
         


         if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
         }


         $email = trim($_POST['text_email']);
         $nome_completo = trim($_POST['text_nome_completo']);
         $morada = trim($_POST['text_morada']);
         $cidade = trim($_POST['text_cidade']);
         $telefone = trim($_POST['text_telefone']);

         
         
         
         if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {                   
            $_SESSION['erro']= 'Endereço de email inválido';
            $this->alterar_dados_pessoais();     
            return;
         }

         
         if (empty($nome_completo) || empty($morada) || empty($cidade)) {
            $_SESSION['erro']= 'Campos Obrigatórios não informados';
            $this->alterar_dados_pessoais();     
            return;
         }

         
         $Email_outro_Clie = new Clientes();
         $outro_Clie=$Email_outro_Clie->verificar_email_existe_base($email, $_SESSION['cliente']);
         if ($outro_Clie) {
            $_SESSION['erro']= 'Email existente em outro cliente';
            $this->alterar_dados_pessoais();     
            return;            
         }
         
         
         $clientes = new clientes();
         $clientes -> atualizar_dados_cliente($email, $nome_completo, $morada, $cidade, $telefone);
         store::redirect('perfil');
         $_SESSION['usuario']=$email;
         $_SESSION['nome_cliente']=$nome_completo;

      }

      public function alterar_password() {
         echo 'alterar dados password';

      }

      public function alterar_password_submit() {
         echo 'alterar dados password submit';

      }

      public function historico_encomendas() {
         echo 'historico encomendas';

      }
      
       


}


