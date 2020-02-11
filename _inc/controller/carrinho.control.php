<?php

require '../../io.php';

$carrinho = new Carrinho($conexao);

if ($_POST) {
    try {
        $conexao->begin();

        if ($_POST['id_popup'] != "") {
            $carrinho->setCodigoProduto($_POST['id_popup']);
            $carrinho->setQuantidade($_POST['quantidade_popup']);
            $carrinho->salvar();
        }

        if ($_POST['excluir'] == "1") {
            $carrinho->setCodigoProduto($_POST['id_excluir_popup']);
            $carrinho->excluir();
        }

        $conexao->commit();
        echo "ok";

    } catch (Exception $ex) {
        $conexao->rollBack();
        echo $ex->getMessage();
    }
}


