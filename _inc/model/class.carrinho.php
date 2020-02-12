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
        return;

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
            $st->bindValue(':carrinho', $this->codigoCarrinho, PDO::PARAM_INT);
            $st->bindValue(':produto', $this->getCodigoProduto(), PDO::PARAM_INT);
            $st->bindValue(':quantidade', $this->getQuantidade(), PDO::PARAM_INT);
            $st->execute();
    }

    public function excluir()
    {
        $st = $this->conexao->prepare("
            DELETE FROM
                carrinhoproduto 
            WHERE
                prd_id = " . $this->getCodigoProduto() . "
                AND car_id = 1
        ");
        $st->execute();
    }

    public function atualizar()
    {
        $st = $this->conexao->prepare("
            UPDATE 
                carrinhoproduto 
                SET quantidade = " . $this->getQuantidade() . " 
            WHERE 
                prd_id = " . $this->getCodigoProduto() . " 
                AND car_id = 1"
        );
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
                AND cp.car_id = 1  
            GROUP BY
                p.prd_id
            ";

        return $this->conexao->select($sql);
    }

    public function qtdeProdutoCarrinho(){

        $sql = "
            SELECT                
                quantidade 
            FROM 
                carrinhoproduto 
            WHERE 
                prd_id = " . $this->getCodigoProduto() . "
                AND car_id = 1
            ";

        return $this->conexao->select($sql);
    }
}

