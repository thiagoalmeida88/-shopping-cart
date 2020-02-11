<?php

class Carrinho
{
    protected $codigoProduto;
    protected $codigoCarrinho = 1;
    protected $quantidade;

    public function getCodigoProduto()
    {
        return $this->codigoProduto;
    }

    public function setCodigoProduto($codigoProduto)
    {
        $this->codigoProduto = $codigoProduto;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function __construct(Conexao $conexao)
    {
        $this->conexao = $conexao;
    }

    public function salvar()
    {
        $sql = "
            INSERT INTO carrinhoproduto 
                (
                car_id,
                prd_id,
                quantidade
                ) 
            VALUES 
                (
                :carrinho,
                :produto,
                :quantidade
                )
        ";

        $st = $this->conexao->prepare($sql);
        $st->bindParam(':carrinho', $this->codigoCarrinho, PDO::PARAM_INT);
        $st->bindParam(':produto', $this->getCodigoProduto(), PDO::PARAM_INT);
        $st->bindParam(':quantidade', $this->getQuantidade(), PDO::PARAM_INT);
        $st->execute();
    }

    public function excluir()
    {
        $sql = "
            DELETE FROM
                carrinhoproduto 
            WHERE
                prd_id = :produto
        ";

        $st = $this->conexao->prepare($sql);
        $st->bindParam(':produto', $this->getCodigoProduto(), PDO::PARAM_INT);
        $st->execute();
    }

    public function listaProdutosCarrinho(){

        $sql = "
            SELECT 
                p.prd_id,
                p.prd_imagem AS imagem,
                p.prd_nome AS nome,
                SUM(cp.quantidade) AS quantidade, 
                p.prd_preco AS preco,
                SUM(p.prd_preco * cp.quantidade) AS total
            FROM 
                produto p
                INNER JOIN carrinhoproduto cp ON cp.prd_id = p.prd_id
            GROUP BY
                p.prd_id
            ";

        return $this->conexao->select($sql);
    }
}

