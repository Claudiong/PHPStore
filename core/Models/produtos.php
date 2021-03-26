<?php

namespace core\models;
use core\classes\Database;
use core\classes\Store;

class Produtos {

    public function lista_produtos_disponiveis($categoria){
        $bd = new Database();
        $sql = "SELECT * FROM PRODUTOS WHERE VISIVEL=1";
        $categorias = $this->lista_categorias();
        if (in_array($categoria, $categorias)) {
            $sql.=" AND categoria = '$categoria'"; 

        }
        
        $produtos = $bd->select($sql);
        return $produtos;

    }


    public function lista_categorias() {
        $bd= new Database();
        $resultados = $bd->select("SELECT DISTINCT categoria FROM produtos");
        $categorias = [];
        foreach ($resultados as $resultado) {

            array_push($categorias,$resultado->categoria);
        }
        return $categorias;

        


    }

    public function verificar_stock_produto($id_produto) {
        $bd= new Database();
        $parametros = [':id_produto'=>$id_produto];
        $resultados = $bd->select("SELECT * FROM produtos where id_produto=:id_produto and visivel = 1 and stock>0", $parametros);
        return count($resultados) != 0 ? true : false;
        


    }

    public function buscar_produtos_por_ids($ids) {
        $bd= new Database();        
        $resultados = $bd->select("SELECT * FROM PRODUTOS WHERE id_produto in ($ids)");              
        return $resultados;

    }


    

}
