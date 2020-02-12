<!DOCTYPE html>
<?php

require 'io.php';

$produto = new Produto($conexao);
$lista = $produto->lista();

?>
<html lang="pt-br">
    <?php include '_head.php'; ?>
<body>
    <div id="wrapper">
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="container">
                    <div class="row pull-left">
                        <div class="col-sm-12">
                            <h2>Produtos</h2>
                            <h5>Todos os produtos cadastrados</h5>
                        </div>
                    </div>
                    <div class="row pull-right">
                        <div class="col-sm-6">
                            <?php include 'carrinho.php'; ?>
                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->
                <hr/>
                <?php if (isset($lista) && count($lista) > 0) { ?>
                    <div class="container">
                        <div class="row">
                            <?php $i = 0; ?>
                            <?php foreach ($lista as $row) { ?>
                                <div class="col-sm-4 lista-produto">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <?php if($row['imagem'] == '') { ?>
                                                <img alt="Sem imagem" src="img/produtos/unnamed.png" class="user-image img-responsive"/>
                                            <?php }else{ ?>
                                                <img alt="Imagem do produto" width="150" height="150" src="img/produtos/<?= $row['imagem'] ?>" class="user-image img-responsive"/>
                                            <?php } ?>
                                            <h4><b><?= $row['nome']?></b></h4>
                                            <h5><?= $row['descricao']?></h5>
                                            <h4 class="text-muted">
                                                R$<?= number_format($row['preco'], 2, ',', '.') ?>
                                            </h4>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" id="imagem<?= $i ?>" value="<?= $row['imagem'] ?>">
                                            <input type="hidden" id="id<?= $i ?>" value="<?= $row['prd_id'] ?>">
                                            <input type="hidden" id="nome<?= $i ?>" value="<?= $row['nome'] ?>">
                                            <button data-target="#detalhesCompra" onclick="return adicionarProduto(<?= $i ?>);" role="button" class="btn btn-primary" title="Adicionar produto" data-toggle="modal"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;&nbsp;Adicionar</button>
                                        </div>
                                    </div>
                                </div>
                            <?php $i++; ?>
                            <?php } ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-warning"><b><span class="glyphicon glyphicon-exclamation-sign"></span> Ops!</b> Nenhum produto encontrado.</div>
                <?php } ?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
<!-- /. WRAPPER  -->
</body>

    <div class="modal fade" id="detalhesCompra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formProduto" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Adicionar produto</h4>
                    </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_popup" id="id_popup">
                            <input type="hidden" name="opcao" id="opcao" value="adicionar">
                            <div class="panel-body">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <img alt="Imagem do produto" id="imagem_popup" width="150" height="150" class="user-image img-responsive"/>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Produto</label>
                                        <input type="text" id="nome_popup" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Quantidade</label>
                                        <input type="text" name="quantidade_popup" id="quantidade_popup" class="form-control num">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button id="salvarProduto" class="btn btn-success" type="submit"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;&nbsp;Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script src="assets/js/cadastro.js"></script>
<script>

    $('.num').keypress(function (event) {
        var tecla = (window.event) ? event.keyCode : event.which;
        if ((tecla > 47 && tecla < 58))
            return true;
        else {
            if (tecla != 8)
                return false;
            else
                return true;
        }
    });

    function adicionarProduto(valor) {

        var img = "unnamed.png";

        if($("#imagem" + valor).val() !== ""){
            img = $("#imagem" + valor).val();
        }

        document.getElementById("imagem_popup").src = "img/produtos/" + img;

        $("#id_popup").val($("#id" + valor).val());
        $("#nome_popup").val($("#nome" + valor).val());

        $('#detalhesCompra').on('shown.bs.modal', function () {
            $('#quantidade_popup').select().val(1);
        });

        return false;
    }

    $('#salvarProduto').click(function(e){
        e.preventDefault();

        setTimeout(function () {

            var form = $('#formProduto');

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
                complete: function() {
                    setTimeout(function () {
                        $('#detalhesCompra').modal('toggle');
                    }, 200);
                },
                error: function(xhr,er) {
                    alert('Erro: ' + xhr.status + ' - ' + xhr.statusText + '<br />Tipo de erro: ' + er);
                }
            });
        }, 500);
    });

    $(document).ready(function() {
        $('#pop').fadeToggle();
    });

</script>
</html>