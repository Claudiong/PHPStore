
<div class="container espaco-fundo">
    <div class="row">

        <div class="col-12 text-center my-4">
            <a href="?a=loja&c=todos" class="btn btn-primary">Todos</a>
        <?php foreach ($categorias as $categoria):?>
            <a href="?a=loja&c=<?= $categoria ?>" class="btn btn-primary">
                <?= ucfirst(preg_replace("/\_/"," ", $categoria))?>
            </a>         

           <?php endforeach;?>    
         
         
        </div>

    </div>
    <!-- produtos -->
    <div class="row">        
    <?php if(count($produtos)==0):?>
        <div class="text-center my-5">
            <h3>Não existem produtos disponiveis</h3>        
        </div>   
    <?php else:?>
        <?php foreach($produtos as $produto):?>
            <div class="col-sm-4 col-6 p-2">
        
              <div class="text-center p-3 box-produto">
                   <img src="assets/images/produtos/<?= $produto->imagem ?>" class="img-fluid">
                   <h3><p><?= $produto->nome_produto ?></p></h3>
                   <h2><p><?= 'R$' . preg_replace("/\./",",", $produto->preco) ?></p></h2>
                   <!-- <p><small><?= $produto->descricao ?></small></p> -->
                   <div>
                     <?php if ($produto->stock>0):?>
                     <button class="btn btn-info btn-sm" onclick="adicionar_carrinho(<?=$produto->id_produto ?>)">
                                   <i class="fas fa-shopping-cart me-2"> adicionar ao carrrrrinho</i></button>
                              
                     <?php else : ?>
                        <button class="btn btn-danger btn-sm" >
                                   <i class="fas fa-shopping-cart me-2"> Indisponível</i></button> 
                     <?php endif ?>        

                     
                   </div>

            
                </div>
        
            </div>
            <?php endforeach; ?>
    <?php endif?>      
    
    </div>

</div>


<!--
     [6] => stdClass Object
        (
            [id_produto] => 7
            [categoria] => mulher
            [nome_produto] => Vestido Verde
            [descricao] => Qui aliquid sed quisquam autem quas recusandae labore neque laudantium iusto modi repudiandae doloremque ipsam ad omnis inventore, cum ducimus praesentium. Consectetur!
            [imagem] => vestido_verde.png
            [preco] => 48.85
            [stock] => 100
            [visivel] => 1
            [created_at] => 2021-02-06 19:45:22
            [updated_at] => 2021-02-06 19:45:28
            [deleted_at] => 
        )-->