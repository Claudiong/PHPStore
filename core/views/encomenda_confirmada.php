<div class="container">
    <div class="row my-5">
        <div class="col text-center offset-sm-3">
           <h3 class="text-center"> Encomenda Confirmada </h3>
           <p>Obrigado pela sua compra </p> 


    <div class="my-5">
        <h4>Dados de Pagamento</h4>
        <p>Conta Bancária:29858-4</p>
        <p>Codigo da encomenda:<strong><?=$codigo_encomenda ?></strong></p>
        <p>Total da encomenda:<strong><?=number_format($total_encomenda, 2, ',', '.') ?></strong></p>
    </div>

           <p>Enviaremos após confirmação de pagamento </p>
           <p>Verifique seu email</p>
           <div class="my-5"> <a href="?a=inicio" class="btn btn-primary">Voltar</a></div> 
          
        </div>
    </div>
</div>