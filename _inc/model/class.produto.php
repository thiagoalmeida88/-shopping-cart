<?php

class Produto
{
    protected $codigo;
    protected $nome;
    protected $descricao;
    protected $valor;
    protected $imagem;

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getImagem()
    {
        return $this->imagem;
    }

    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }

    public function __construct(Conexao $conexao)
    {
        $this->conexao = $conexao;
    }

    public function lista()
    {
        $sql =
            '
            SELECT 
                prd_id,
                prd_nome AS nome,
                prd_descricao AS descricao,
                prd_preco AS preco,
                prd_imagem AS imagem
            FROM
                produto                    
            ';

        return $this->conexao->select($sql);
    }
}

