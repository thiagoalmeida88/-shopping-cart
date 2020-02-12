<?php

$carrinho = new Carrinho($conexao);
$listaProdutosCarrinho = $carrinho->listaProdutosCarrinho();

?>
<div class="head">
    <div class="right menu-desktop">
        <a class="btn btn-default" href="#" id="app" title="Carrinho de compras" aria-expanded="false" role="button" tabindex="0"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;&nbsp;Carrinho</a>
    </div>
    <div id="pop">
        <?php if (isset($listaProdutosCarrinho) && count($listaProdutosCarrinho) > 0) { ?>
            <div style="height: 89%; overflow-x: auto;">
                <table class="table">
                    <tbody>
                    <div style="position: relative; width: 100%; top: 0; padding-top: 20px; background: #FFFFFF">
                        <div id="mensagem-alerta"></div>
                    </div>
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
                        <input type="hidden" id="produto_carrinho<?= $i ?>" value="<?= $row['nome'] ?>">
                        <input type="hidden" id="quantidade_produto<?= $i ?>" value="<?= $row['quantidade'] ?>">
                        <input type="hidden" id="id_excluir<?= $i ?>" value="<?= $row['prd_id'] ?>">
                        <td><button data-toggle="modal" data-target="#popupExcluir" class="btn btn-danger btn-sm" onclick="return excluirProduto(<?= $i ?>)" title="Excluir"><span class="glyphicon glyphicon-trash"></span></button></td>
                    </tr>
                    <?php $i++; ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <div class="modal-footer" style="position: absolute; width: 100%; bottom: 0; background: white; padding-top: 10px;">
            <h4><b>Total:</b>
                R$<?= number_format($total, 2, ',', '.') ?></h4>
        </div>
        <?php } else { ?>
            <div class="alert alert-warning"><b><span class="glyphicon glyphicon-exclamation-sign"></span> Ops!</b> Nenhum produto encontrado.</div>
        <?php } ?>
    </div>
</div>

<div class="modal fade" id="popupExcluir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formExcluirProduto" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><b>Atenção!</b>&nbsp;&nbsp;Deseja realmente excluir o produto do carrinho?</h4>
                </div>
                    <div class="modal-body">
                        <input type="hidden" id="quantidade_soma" name="quantidade_soma">
                        <input type="hidden" id="id_excluir_popup" name="id_excluir_popup">
                        <input type="hidden" name="excluir" id="excluir">
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Produto</label>
                                    <input type="text" id="produto_excluir" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Quantidade</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-number" data-type="minus" data-field="quantidade_excluir_popup">
                                            <span class="glyphicon glyphicon-minus"></span>
                                        </button>
                                    </span>
                                    <input readonly="readonly" class="form-control num" id="quantidade_excluir_popup" name="quantidade_excluir_popup"  />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quantidade_excluir_popup">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button id="excluirProduto" onclick="fecharModal()" class="btn btn-danger" type="submit">Sim</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function excluirProduto(valor) {
        $("#excluir").val("1");
        $("#produto_excluir").val($("#produto_carrinho" + valor).val());
        $("#quantidade_excluir_popup").val($("#quantidade_produto" + valor).val());
        $("#quantidade_soma").val($("#quantidade_produto" + valor).val());
        $("#id_excluir_popup").val($("#id_excluir" + valor).val());

        return false;
    }

    function fecharModal() {
        $('#popupExcluir').modal('toggle');
    }

    $('#excluirProduto').click(function(e){
        e.preventDefault();

        setTimeout(function () {


            var form = $('#formExcluirProduto');

            $.ajax({
                url: '_inc/controller/carrinho.control.php',
                type: 'POST',
                cache: false,
                data: form.serialize(),
                success: function(data) {
                    if (data == "ok") {
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                        setTimeout(function () {
                            mostraAlertaOK("Produto adicionado com sucesso!");
                        }, 200);
                    }
                },
                error: function(xhr,er) {
                    alert('Erro: ' + xhr.status + ' - ' + xhr.statusText + '<br />Tipo de erro: ' + er);
                }
            });
        }, 100);
    });

    $('#app').on("click", function () {
        $('#pop').fadeToggle();
    });

    $('.btn-number').click(function(e){
        e.preventDefault();

        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());

        if (!isNaN(currentVal)) {
            if(type === "minus")
                input.val(currentVal == 1? currentVal : currentVal - 1);
            else if(type === "plus")
                input.val(currentVal == $("#quantidade_soma").val()? currentVal : currentVal + 1);
        } else {
            input.val(0);
        }
    });
</script>