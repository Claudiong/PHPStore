<div class="container">
   <div class="row my-5">
      <div class="col">
         <table class="table table-striped">
            <?php foreach ($dados_cliente as $key => $valor) : ?>
               <tr>
                  <td class="text-end" width="50%"><strong><?= $key ?>:</strong></td>
                  <td class="text-left" width="50%"><?= $valor ?></td>
               </tr>
            <?php endforeach ?>
         </table>
      </div>
   </div>
</div>

