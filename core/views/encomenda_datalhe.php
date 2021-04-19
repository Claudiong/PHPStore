<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center"> Detalhe encomenda </h1>

            <div class="row">
                <div class="col">
                    
                    <div class="p-2 my-3">
                        <span><strong>Data da Encomenda</strong></span><br>
                        <?= date('d/m/Y', strtotime($dados_encomenda->data_encomenda)) ?>
                    </div>

                    <div class="p-2 my-3">
                        <span><strong>Endereço</strong></span><br>
                        <?= $dados_encomenda->morada ?>
                    </div>

                    <div class="p-2 my-3">
                        <span><strong>Cidade</strong></span><br>
                        <?= $dados_encomenda->cidade ?>
                    </div>


                </div>

                <div class="col">

                    <div class="p-2 my-3">
                        <span><strong>Email</strong></span><br>
                        <?= $dados_encomenda->email ?>
                    </div>

                    <div class="p-2 my-3">
                        <span><strong>telefone</strong></span><br>
                        <?= empty($dados_encomenda->telefone) ? '&nbsp-' : $dados_encomenda->telefone ?>
                    </div>

                    <div class="p-2 my-3">
                        <span><strong>Código</strong></span><br>
                        <?= $dados_encomenda->codigo_encomenda ?>
                    </div>

                </div>


                <div class="col align-self-center">
                    <div>
                        <span><strong>Status</strong></span><br>
                        <?= $dados_encomenda->status ?>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th class="text-center">Quantidade</th>
                                <th class="text-end">Preço Unitário</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php foreach ($produtos_encomenda as $produtos) : ?>
                                <tr>
                                    <td><?= $produtos->designacao_produto ?></td>
                                    <td class="text-center"><?= $produtos->quantidade ?></td>
                                    <td class="text-end"><?= number_format($produtos->preco_unidade, 2, ",", ".")  ?></td>
                                    <?php $total+=$produtos->preco_unidade ?>
                                </tr>mlehor

                            <?php endforeach; ?>

                            <tr>
                                    <td></td>                                    
                                    <td></td>
                                    <td class="text-end"><strong>Total da Encomenda : </strong><?=number_format($total, 2, ",", ".")  ?></td>
                                    
                                </tr>



                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3 mb-4">
                <div class="col text-center">
                <a href='?a=historico_encomendas' class="btn btn-primary"> Voltar </a>
                
                
                </div>
            </div>                    



        </div>
    </div>
</div>