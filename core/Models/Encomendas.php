<?php

namespace core\models;
use core\classes\Database;
use core\classes\Store;


class Encomendas {

   protected $conexao;

   public function __construct()
   {      
      $this->conexao = new Database();      
   }


   public function guardar_encomenda($dados_encomenda, $dados_produtos) {

   $bd = new Database();


   $parametros = [
   ':id_cliente'=> $_SESSION['cliente'],
   ':morada'=> $dados_encomenda['morada'],
   ':cidade'=> $dados_encomenda['cidade'],
   ':email'=> $dados_encomenda['email'],
   ':telefone'=> $dados_encomenda['telefone'],
   ':codigo_encomenda'=> $dados_encomenda['codigo_encomenda'],
   ':status'=> $dados_encomenda['status'],
   ':mensagem'=> $dados_encomenda['mensagem']
   ];

   $bd->insert("INSERT INTO encomendas VALUES(
   0,
   :id_cliente,
   NOW(),
   :morada,
   :cidade,
   :email,
   :telefone,
   :codigo_encomenda,
   :status,
   :mensagem,
   NOW(), NOW())", $parametros);

   //buscar o id da enconenda
   $id_encomenda = $bd->select("SELECT MAX(id_encomenda) id_encomenda from encomendas")[0]->id_encomenda;
   foreach ($dados_produtos as $produto) {     
     $parametros = [
      ':id_encomenda'=>$id_encomenda,
      ':designacao_produto'=>$produto['designacao_produto'],
      ':preco_unidade'=>$produto['preco_unidade'],
      ':quantidade'=>$produto['quantidade'],
    ];

   $bd->insert ("INSERT INTO ENCOMENDA_PRODUTO VALUES (0,:id_encomenda,:designacao_produto, :preco_unidade, :quantidade,NOW())", $parametros);
  }
 } 


public function buscar_historico_encomendas($id_cliente) {

    $parametros = [
     ':id_cliente'=>$id_cliente
    ];

    $resultados=$this->conexao->select("Select id_encomenda, codigo_encomenda, data_encomenda, 
   status From encomendas
   WHERE id_cliente=:id_cliente
   order by data_encomenda DESC",$parametros);
  return $resultados;

} 


public function verificar_encomenda_cliente($id_cliente, $id_encomenda) {

  $parametros = [
   ':id_cliente'=>$id_cliente,
    'id_encomenda'=>$id_encomenda
  ];

  $resultados=$this->conexao->select("Select id_encomenda From encomendas
 WHERE id_cliente=:id_cliente and
 id_encomenda = :id_encomenda 
 order by data_encomenda DESC",$parametros);
 return count($resultados)==0 ? false : true; 


} 


public function detalhes_de_encomenda ($id_cliente, $id_encomenda) {
  $parametros = [
    ':id_cliente'=> $id_cliente, 
    ':id_encomenda'=>$id_encomenda
  ];

  $dados_encomenda=$this->conexao->select("
  Select * 
  from encomendas where id_cliente=:id_cliente 
  and id_encomenda-:id_encomenda", $parametros)[0];

  $parametros = [
    ':id_encomenda'=>$id_encomenda
  ];
  
  $produtos_encomenda=$this->conexao->select("
  Select * 
  from encomenda_produto where id_encomenda=:id_encomenda", $parametros);

  return ['dados_encomenda'=>$dados_encomenda,
          'produtos_encomenda'=>$produtos_encomenda 
];

}



public function verifica_pagamento($codigo_encomenda) {

  $parametros = ['codigo_encomenda' => $codigo_encomenda];
  $resultados=$this->conexao->select('select * from encomendas where codigo_encomenda=:codigo_encomenda and status="Pendente"', $parametros);

  if (count($resultados)==0) {
    return false;
  } 
  else {
    $resultados=$this->conexao->Update('update encomendas set status="EM PROCESSAMENTO", updated_at=now() where codigo_encomenda=:codigo_encomenda and status="Pendente"', $parametros);
    return true;
  }

}











}