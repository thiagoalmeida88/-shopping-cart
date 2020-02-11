<?php

$carrinho = new Carrinho($conexao);
$listaProdutosCarrinho = $carrinho->listaProdutosCarrinho();

?>
<div class="head">
    <div class="right menu-desktop">
        <a class="btn btn-default" href="#" id="app" title="Carrinho de compras" aria-expanded="false" role="button" tabindex="0"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;&nbsp;Carrinho</a>
    </div>
    <div id="pop" style="overflow: auto">
        <?php if (isset($listaProdutosCarrinho) && count($listaProdutosCarrinho) > 0) { ?>
        <table class="table">
            <tbody>
            <?php $total = 0; $i = 0; ?>
            <?php foreach ($listaProdutosCarrinho as $row) { ?>
            <?php
                $total += $row['total'];
            ?>
            <tr>
                <td>
                    <?php if($row['imagem'] == '') { ?>
                        <img alt="Sem imagem" width="50" height="50" src="img/produtos/unnamed.png" class="user-image img-responsive"/>
                    <?php }else{ ?>
                        <img alt="Imagem do produto" width="50" height="50" src="img/produtos/<?= $row['imagem'] ?>" class="user-image img-responsive"/>
                    <?php } ?>
                </td>
                <td><?= $row['nome']?></td>
                <td><?= $row['quantidade']?></td>
                <td>R$<?= number_format($row['total'], 2, ',', '.') ?></td>
                <input type="hidden" id="nome<?= $i ?>" value="<?= $row['nome'] ?>">
                <input type="hidden" id="id_excluir<?= $i ?>" value="<?= $row['prd_id'] ?>">
                <td><button data-toggle="modal" data-target="#popupExcluir" class="btn btn-danger btn-sm" onclick="return excluirProduto(<?= $i ?>)" title="Excluir"><span class="glyphicon glyphicon-trash"></span></button></td>
            </tr>
            <?php $i++; ?>
            <?php } ?>
            </tbody>
                <tr>
                    <td><h4><b>Total:</b></h4></td>
                    <td><h4>R$<?= number_format($total, 2, ',', '.') ?></h4></td>
                </tr>
        </table>
        <?php } else { ?>
            <div class="alert alert-warning"><b><span class="glyphicon glyphicon-exclamation-sign"></span> Ops!</b> Nenhum produto encontrado.</div>
        <?php } ?>
    </div>
</div>

<div class="modal fade" id="popupExcluir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Atenção</h4>
            </div>
            <form id="formExcluirProduto" method="post">
                <div class="modal-body">
                    <input type="hidden" name="excluir" id="excluir">
                    <div class="form-group">
                        Deseja realmente excluir o produto do carrinho?
                    </div>
                    <div class="form-group">
                        <input type="text" id="produto_excluir" class="form-control" disabled>
                    </div>
                    <input type="hidden" id="id_excluir_popup" name="id_excluir_popup">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button id="excluirProduto" class="btn btn-primary" name="btnExcluir">Sim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function excluirProduto(valor) {
        $("#excluir").val("1");
        $("#produto_excluir").val($("#nome" + valor).val());
        $("#id_excluir_popup").val($("#id_excluir" + valor).val());
        return false;
    }

    $('#excluirProduto').click(function(e){
        e.preventDefault();

        var serializeDados = $('#formExcluirProduto').serialize();

        $.ajax({
            url: '_inc/controller/carrinho.control.php',
            type: 'POST',
            data: serializeDados,
            success: function(data) {
                window.location.reload();
            },
            error: function(xhr,er) {
                alert('Erro: ' + xhr.status + ' - ' + xhr.statusText + '<br />Tipo de erro: ' + er);
            }
        });

    });

    $('#app').on("click", function () {
        $('#pop').fadeToggle();
    });
</script>