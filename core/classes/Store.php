<?php
namespace core\classes;

use Exception;

class Store {
    
  public static function layout($estruturas, $dados=null) {
    if (!is_array($estruturas)) {
      throw new Exception("coleção de estrutura inválida");
    }  

     if (!empty($dados) && is_array($dados)) {
     extract($dados);
     }

     foreach($estruturas as $estrutura) {
     include("../core/views/$estrutura.php");
     }

  }

  public static function clienteLogado() {

     return isset($_SESSION['cliente']);

  }

   public static function criarhash($num_caracteres = 12) {

      $chars = '01234567890123456789abcdefghijklmnopqrstuwxyzabcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZABCDEFGHIJKLMNOPQRSTUWXYZABCDEFGHIJKLMNOPQRSTUWXYZABCDEFGHIJKLMNOPQRSTUWXYZ';
      return substr(str_shuffle($chars), 0, $num_caracteres);

   }


   public static function redirect($rota='') {
      header("location:" .BASE_URL . "?a=$rota");
   }

   public static function printdata($data){

      if (is_array($data) || is_object($data)) {
         echo '<pre>';
         print_r($data);
      } else {
         echo '<pre>';
         echo $data; 

      } 
      die('<br>TERMINADO');
         
   }

   Public static function gerarCodigoEncomenda() {
      $codigo = "";
      $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ";
      $codigo .= substr(str_shuffle($chars),0,2);
      $codigo .= rand(100000,999999);
      return $codigo;
   }


   

}