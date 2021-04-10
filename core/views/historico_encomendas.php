<?php 
use core\classes\store;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php if (empty($historico_encomendas)) : ?>
                <strong>><p class="text-center"> Sem Encomendas </p></strong>
            <?php else : ?>
                <h1 class="text-center"> Histórico das Encomendas </h1>

                <table class="table">
                    <thead class="table-dark table-striped">
                        <tr>
                            <th>Data Encomenda</th>
                            <th class="text-center">Código Encomenda</th>
                            <th class="text-center">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historico_encomendas as $encomendas) : ?>
                            <tr>
                                <td class="align-middle">
                                    <?= date('d/m/Y', strtotime($encomendas->data_encomenda))  ?>
                                </td>
                                <td class="text-center align-middle">
                                    <?= $encomendas->codigo_encomenda ?>
                                </td>
                                <td class="text-center align-middle">
                                    <?= $encomendas->status ?>
                                </td>
                                <td class="text-center align-middle">
                                    <a href="?a=detalhe_encomenda&id=<?= Store::aesEncriptar($encomendas->id_encomenda)?>"> Detalhes </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>                
                <p class="text-end"> Total Encomendas:<strong><?= count($historico_encomendas) ?></strong></p>
            <?php endif; ?>
            
        </div>
    </div>
</div>