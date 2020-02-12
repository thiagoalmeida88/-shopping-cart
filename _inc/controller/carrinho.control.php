<?php

require '../../io.php';

$carrinho = new Carrinho($conexao);

try {
    $conexao->begin();

    if ($_POST) {

        if (isset($_POST['id_popup']) && is_numeric($_POST['id_popup'])) {
            $carrinho->setCodigoProduto($_POST['id_popup']);
        }

        if (isset($_POST['opcao']) == "adicionar") {
            $carrinho->setQuantidade($_POST['quantidade_popup']);

            $quantidadeProduto = $carrinho->qtdeProdutoCarrinho();

            if(count($quantidadeProduto) > 0) {
                $quantidade = $quantidadeProduto[0]['quantidade'] + $carrinho->getQuantidade();
                $carrinho->setQuantidade($quantidade);
                $carrinho->atualizar();
            } else {
                $carrinho->salvar();
            }
        }

        if (isset($_POST['excluir']) && $_POST['excluir'] == "1") {
            $carrinho->setCodigoProduto($_POST['id_excluir_popup']);
            $carrinho->setQuantidade($_POST['quantidade_excluir_popup']);

            $quantidadeProduto = $carrinho->qtdeProdutoCarrinho();

            if(count($quantidadeProduto) > 0) {
                $qtdTotal = $quantidadeProduto[0]['quantidade'];
            }

            if ($qtdTotal == $carrinho->getQuantidade()) {
                $carrinho->excluir();
            } else {
                $carrinho->atualizar();
            }
        }
    }

    echo "ok";
    $conexao->commit();

} catch (Exception $ex) {
    $conexao->rollBack();
    echo $ex->getMessage();
}



