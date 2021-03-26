 <div class="container">
   <div class="row">
     <div class="col">
       <h3 class="my-3"> Resumo </h3>
       <hr>
     </div>
   </div>
 </div>
 <div class="container">
   <div class="row">
     <div class="col">
       <div style="margin-bottom :80px;">
         <table class="table">
           <thead>
             <tr>
               <th>Produto</th>
               <th class="text-center">Quantidade</th>
               <th class="text-end">Valor Total</th>
               <th></th>
             </tr>
           </thead>

           <tbody>
             <?php
              $index = 0;
              $total_rows = count($carrinho) - 1;
              ?>

             <?php foreach ($carrinho as $produto) : ?>

               <?php if ($index != $total_rows) : ?>
                 <tr>
                   <td class="align-middle">
                     <?= $produto['titulo'] ?>
                   </td>
                   <td class="text-center align-middle">
                     <?= $produto['quantidade'] ?>
                   </td>
                   <td class="text-end align-middle">
                     <?= number_format($produto['preco'], 2, ',', '.')  ?>
                   </td>
                 </tr>
               <?php else : ?>
                 <tr>
                   <!-- <td></td> -->
                   <td></td>
                   <td class="text-end">
                     <h4> Total:</h4>
                   </td>
                   <td class="text-end align-middle">
                     <h4><?= number_format($produto, 2, ',', '.')  ?></h4>
                   </td>
                   <td></td>
                 </tr>
               <?php endif; ?>
               <?php $index++; ?>
             <?php endforeach; ?>
           </tbody>
         </table>


         <div>
           <h5 class="bg-dark text-white p-2"> Dados do Cliente</h5>
           <div class="row mt-4">
             <div class="col">
               <p>Nome:<strong> <?= $cliente->nome_completo ?> </strong></p>
               <p>Endereço:<strong> <?= $cliente->morada ?> </strong></p>
               <p>Cidade:<strong> <?= $cliente->cidade ?> </strong></p>
             </div>
             <div class="col">
               <p>Email:<strong> <?= $cliente->email ?> </strong></p>
               <p>Telefone:<strong> <?= $cliente->telefone ?> </strong></p>
             </div>
           </div>

           <div class="form-check">
             <input class="form-check-input" onchange="usar_morada_alternativa()" type="checkbox" name="check_morada_alternativa" id="check_morada_alternativa">             
             <label class="form-check-label" for="check_morada_alternativa">Definir endereço alternativo</label>            
             
           </div>

           <div id="morada_alternativa" style="display: none">
               <div class="mb-3">
                  <label class="form-label">Endereço:</label>
                  <input type="text" class="form-control"  id="text_morada_alternativa">               
               </div>

               <div class="mb-3">
                  <label class="form-label">Cidade:</label>
                  <input class="form-control" type ="text" id="text_cidade_alternativa">               
               </div>

               <div class="mb-3">
                  <label class="form-label">Email:</label>
                  <input class="form-control" type ="email" id="text_email_alternativa">               
               </div>

               <div class="mb-3">
                  <label class="form-label">Telefone:</label>
                  <input class="form-control" type ="text" id="text_telefone_alternativa">               
               </div>

               
           
           </div>


           <!-- DADOS DE PAGAMENTO -->
           <h5 class="bg-dark text-white p-2"> Dados do Pagamento</h5>
           <div class="row">
              <div class="row">
                <div class="col">
                   <p>Conta Bancária:111111</p>
                   <p>Código da Encomenda:<strong><?= $_SESSION['codigo_encomenda']?></strong></p>
                   <p>Total:<strong><?= number_format($produto, 2, ',', '.')  ?></strong></p>          
                
                </div>             
              </div>          
           
           </div>



           <div class="row my-5">
             <div class="col">
               <a href="?a=carrinho" class="btn btn-primary"> Cancelar</a>
             </div>

           <div class="col">
             <a href="?a=escolher_metodo_pagamento" onclick="morada_alternativa()" class="btn btn-primary"> Escolher Método Pagto.</a>
           </div>


           <div class="col">
             <a href="?a=confirmar_encomenda" onclick="morada_alternativa()" class="btn btn-primary"> Confirmar Encomenda</a>
           </div>

         </div>
       </div>
     </div>
   </div>
 </div>