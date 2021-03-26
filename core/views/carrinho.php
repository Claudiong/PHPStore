 
<div class="container">
    <div class="row">
        <div class="col">
           <h3 class="my-3"> Seu carrinho </h3>
           <hr>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
      <div class="col">
        <?php if ($carrinho == null): ?>
           <p class="text-center"> Carrinho Vazio </p>
           <div class="mt-4 text-center"> 
              <a href="?a=loja" class="btn btn-sm btn-primary">Voltar a Loja</a>
           </div>
        <?php else : ?>
          <div class="mb-5">  
           <table class="table">
              <thead>
               <tr>
                 <th></th>
                 <th>Produto</th>
                 <th class="text-center" >Quantidade</th>
                 <th class="text-end">Valor Total</th>   
                 <th></th>   
               </tr>         
              </thead>
           
              <tbody>
                  <?php
                  $index=0;
                  $total_rows=count($carrinho)-1; 
                  ?>

                  <?php foreach($carrinho as $produto): ?>
                
                  <?php if ($index !=$total_rows ):?> 
                  <tr>
                    <td> <img src="assets/images/produtos/<?=$produto['imagem'];?>" class="img-fluid" width=50px</td>
                    <td class="align-middle"><h5><?= $produto['titulo']?></h5>    </td>
                    <td class="text-center align-middle"><h5><?= $produto['quantidade']?></h5></td>
                    <td class="text-end align-middle"> <h5><?= number_format($produto['preco'],2,',','.')  ?>  </h5>   </td>
                    <td class="text-center align-middle">
                        <a href="?a=remover_produto_carrinho&id_produto=<?=$produto['id_produto']?>"
                           class="btn btn-danger btn-sm"><i class="fas fa-times text-end"></i></a></td>               
                  </tr>   
                  <?php else : ?>
                  <tr>
                    <td></td>
                    <td></td>                  
                    <td class="text-end"><h5> Total:</h5></td>
                    <td class="text-end align-middle"><h5><?= number_format($produto,2,',','.')  ?></h5></td>
                    <td></td>
                      
                  </tr> 
                  <?php endif; ?>
                  <?php $index++; ?>
                  <?php endforeach; ?>
              </tbody>
           </table>   
           <div class="row">
               <div class="col">
                    <button onclick="limpar_carrinho()" class="btn btn-sm btn-primary">Limpar Carrinho</button>
                       <span class="ms-3" id="confirmar_limpar_carrinho" style="display: none;">Tem Certeza?
                         <button class="btn btn-sm btn-primary"  onclick="limpar_carrinho_off()">Não</button>
                         <a href="?a=limpar_carrinho" class="btn btn-sm btn-primary" >Sim</a>
                       </span>     
                 </div>

               <div class="col text-end">
                   <a href="?a=loja" class="btn btn-sm btn-primary">Continuar comprando</a>
                   <a href="?a=finalizar_encomenda" class="btn btn-sm btn-primary">Finalizar Compra</a>
               </div>
           </div> 
                         
             
        </div>
        <?php endif; ?>
      </div>    
     </div>  
    </div>