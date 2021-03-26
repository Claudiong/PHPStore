<div class="container">
    <div class="row my-5">
        <div class="col-sm-6 offset-sm-3">
          <h3 class="text-center"> Registro de Novo Cliente </h3>
          <form action="?a=criar_cliente" method="post">

          <!--email--> 
          <div class="my-3">
             <label> Email </label>
             <input type="email" name="text_email" placeholder="email" required class="form-control">
          </div>    

          <!--senha 1--> 
          <div class="my-3">
             <label> Senha </label>
             <input type="password" name="text_senha_1" placeholder="Senha" required class="form-control">
          </div>    

          <!--senha 2--> 
          <div class="my-3">
             <label> Repetir a Senha </label>
             <input type="password" name="text_senha_2" placeholder="Repetir a Senha" required class="form-control">
          </div>    

          <!--Nome Completo--> 
          <div class="my-3">
             <label> Nome Completo </label>
             <input type="text" name="text_nome_completo" placeholder="Nome Cmpleto" required class="form-control">
          </div>    

          <!--Endereço--> 
          <div class="my-3">
             <label> Endereço </label>
             <input type="text" name="text_endereco" placeholder="Endereço" required class="form-control">
          </div>    

          <!--Cidade--> 
          <div class="my-3">
             <label> Cidade </label>
             <input type="text" name="text_cidade" placeholder="Cidade" required class="form-control">
          </div>    

          <!--Cidade--> 
          <div class="my-3">
             <label> Telefone </label>
             <input type="text" name="text_telefone" placeholder="Telefone"  class="form-control">
          </div>  

          <!--Cidade--> 
          <div class="my-4">
             <input type="submit" value="Criar Conta" class="btb btn-primary">
          </div>   

          <?php if (isset($_SESSION['erro'])):?>
             <div class="alert-danger text-center p-2">
                <?=$_SESSION['erro'] ?>
                <?php unset($_SESSION['erro'])?>
             </div>
          <?php endif;?>
       </form>            
    </div>
</div>




<!--
    
	email 
	senha 
    senha 2
	nome_completo
	morada 
	cidade 
	telefone	
    -->