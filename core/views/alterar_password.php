<div class="container">
    <div class="row my-5">
        <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-10 offset-1">

        <form action="?a=alterar_password_submit" method="post">

            <div class="form-group">
                <label>Senha Anterior:</label>
                <input type="password" maxlength="50" name="text_password" class="form-control" required >
            </div>

            <div class="form-group">
                <label>Nova Senha:</label>
                <input type="password" maxlength="50" name="text_nova_password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Repita Senha:</label>
                <input type="password" maxlength="50" name="text_repita_password" class="form-control" required>
            </div>

            <div class="text-center my-4">
                <a href="?a=perfil" class="btn btn-primary btn-100">Cancelar</a>
                <input type="submit" value="Salvar" class="btn btn-primary btn-100">
            </div>

        </form>




        <?php if(isset($_SESSION['erro'])):?>
            <div class="alert alert-danger text-center p-2">
                <?= $_SESSION['erro'] ?>
                <?php unset($_SESSION['erro']) ?>
            </div>
        <?php endif; ?>

        </div>
    </div>
</div>