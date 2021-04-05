<?php

namespace core\models;
use core\classes\Database;
use core\classes\Store;

class Clientes {

    
   public function verificar_email_existe_base($email, $id_cliente){
        
      //Verifica na base de dados se existe cliente com mesmo email
      $bd = new Database();
      $parametros = [
         ':email'=>strtolower(trim($email)),
         ':id_cliente'=>$id_cliente
      ];

      $resultados = $bd->select("SELECT ID_CLIENTE, EMAIL FROM CLIENTES WHERE EMAIL = :email and ID_CLIENTE<>:id_cliente"
      , $parametros);
      if (count($resultados) !=0){
        return true;
      }  
      else
        return false;              
  }
   
   
   
   
   
   public function verificar_email_existe($email){
        
        //Verifica na base de dados se existe cliente com mesmo email
        $bd = new Database();
        $parametros = [
           ':email'=>strtolower(trim($email))

        ];

        $resultados = $bd->select("SELECT EMAIL FROM CLIENTES WHERE EMAIL = :email"
        , $parametros);
        if (count($resultados) !=0) {
          return true;
        }  
        else
          return false;              
    }



    public function validar_email($purl){
        
      //Verifica na base de dados se existe cliente com mesmo purl
      $bd = new Database();
      $parametros = [
         ':purl'=>$purl
      ];

      $resultados = $bd->select("SELECT id_cliente FROM CLIENTES WHERE purl = :purl"
      , $parametros);
      if (count($resultados) != 1) {
          return false;             
      }

      $id_cliente = $resultados[0]->id_cliente;

      $parametros = [
         ':id_cliente'=>$id_cliente
      ];

      $bd->update("update CLIENTES set 
          purl = null, 
          ativo=1, 
          updated_at=now() 
          where id_cliente = :id_cliente"
      , $parametros);
      return true;


   }  
    


    public function registrar_cliente (){
  
        $bd = new Database();
        $purl = store::criarhash();
        $parametros = [
           ':email' => strtolower(trim($_POST['text_email'])),
           ':senha' => password_hash($_POST['text_senha_1'],PASSWORD_DEFAULT),
           ':nome_completo'=>trim($_POST['text_nome_completo']),
           ':endereco'=>trim($_POST['text_endereco']),
           ':cidade'=>trim($_POST['text_cidade']),
           ':telefone'=>trim($_POST['text_telefone']),
           ':purl'=>$purl,
           ':ativo'=>0
        ];

        $bd->insert("INSERT INTO clientes VALUES(
           0,
           :email,
           :senha,
           :nome_completo,
           :endereco,
           :cidade,
           :telefone,
           :purl,
           :ativo,
           NOW(),
           NOW(), NULL)", $parametros);

        return $purl;

    }

    public function validar_login($usuario, $senha) {
      $bd = new Database();
      $parametros = [
         ':usuario'=>strtolower(trim($usuario))];  
         

      $resultados = $bd->select("SELECT * FROM CLIENTES WHERE EMAIL = :usuario and ativo=1 and deleted_at is null"
      , $parametros);
      if (count($resultados) !=1) {
        return false;
      } else {
         $usuario= $resultados[0];
         if (!password_verify($senha, $usuario->senha)){
            return false;
         } else {
            return $usuario;
         }

        }   


   }



   public function buscar_dados_cliente($id_cliente) {

      $bd = new Database();
      $parametros = [
         ':id_cliente'=>$id_cliente
      ];

      $resultados = $bd->select("
      SELECT 
        email, 
        nome_completo, 
        morada, 
        cidade, 
        telefone 
      FROM CLIENTES 
      WHERE id_cliente = :id_cliente"
      , $parametros);

      return $resultados[0];



   }




   public function atualizar_dados_cliente ($email, $nome_completo, $endereco, $cidade, $telefone ){
      
      $bd = new Database();
      $parametros = [
         ':email' => strtolower(trim($email)),        
         ':nome_completo'=>trim($nome_completo),
         ':endereco'=>trim($endereco),
         ':cidade'=>trim($cidade),
         ':telefone'=>trim($telefone),
         ':id_cliente'=>$_SESSION['cliente']
      ];

      // echo '<pre>';
      // print_r($parametros);
      // echo '</pre>';
      // die('=====>teste5');

      $bd->update("update clientes set email=:email,      
      nome_completo=:nome_completo,
      morada=:endereco,
      cidade=:cidade,
      telefone=:telefone,Updated_at=NOW()
      where id_cliente=:id_cliente", $parametros);

  }








}