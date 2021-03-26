<?php

namespace core\classes;
use Exception;
use PDO;
use PDOException;

class Database {
private $ligacao;
  //============================================================
private function ligar() {
    //ligar a base de dados
    $this->ligacao = new PDO(
         'mysql:'.
         'host='.MYSQL_SERVER.';'.
         'dbname='.MYSQL_DATABASE.';'.
         'charset='.MYSQL_CHARSET,
         MYSQL_USER,
         MYSQL_PASS,
         array(PDO::ATTR_PERSISTENT=>true)
      );
      //debug
      $this->ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
private function desligar() {
  //desligar da base de dados
   $this->ligacao =  null;

}
public function select($sql, $parametros=null) { 
  $sql=trim($sql);
  if (!preg_match("/^SELECT/i",$sql)) {
    throw new Exception('Base de dados - Não e uma instrução select.');
  }  
  $this->ligar();

  $resultados=null;

   try {
    if (!empty($parametros)) {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute($parametros);
        $resultados = $executar->fetchall(PDO::FETCH_CLASS);
       }
    else {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute();
        $resultados = $executar->fetchAll(PDO::FETCH_CLASS);

        }

    } 
    catch (\PDOException $e) {
       return false;
     }

   $this->desligar();
   return $resultados;
}
public function insert($sql, $parametros=null) { 
    $sql=trim($sql);
    
    if (!preg_match("/^INSERT/i",$sql)) {
    throw new Exception('Base de dados - Não e uma instrução insert.');
    }  
    $this->ligar();

    try {
     if (!empty($parametros)) {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute($parametros);
        }
     else {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute();
        }

     } 
    catch (\PDOException $e) {
       return false;
     }

    $this->desligar();   
} 
public function update($sql, $parametros=null) { 
  
  $sql=trim($sql);
   
  if (!preg_match("/^UPDATE/i",$sql)) {
    throw new Exception('Base de dados - Não e uma instrução update.');
  }  
  $this->ligar();

  try {
    if (!empty($parametros)) {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute($parametros);
        }
    else {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute();
        }

    } 
    catch (\PDOException $e) {
       return false;
     }

   $this->desligar();   
} 
public function delete($sql, $parametros=null) { 

  $sql=trim($sql);

  if (!preg_match("/^DELETE/i",$sql)) {
    throw new Exception('Base de dados - Não e uma instrução delete.');
  }  
  $this->ligar();

  try {
    if (!empty($parametros)) {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute($parametros);
        }
    else {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute();
        }

    } 
    catch (\PDOException $e) {
       return false;
     }

   $this->desligar();   
} 
public function statement($sql, $parametros=null) { 
  
  $sql=trim($sql);
   
  if (preg_match("/^SELECT|UPDATE|INSERT|DELETE/i",$sql)) {
    throw new Exception('Base de dados - Não e uma instrução delete.');
  }  
  $this->ligar();

  try {
    if (!empty($parametros)) {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute($parametros);
        }
    else {
        $executar = $this->ligacao->prepare($sql);
        $executar->execute();
        }

    } 
    catch (\PDOException $e) {
       return false;
     }

   $this->desligar();   
} 
}