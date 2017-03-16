<?php

namespace JP\Sistema\Mapper;

use JP\Sistema\Entity\ProdutoEntity;

class ProdutoMapper
{
    public function gravar(ProdutoEntity $produto)
    {
        $arrProduto = $this->objectToArray($produto);
        if (empty($produto->getId())) { //Inclusão
            return $arrProduto;
        } else { //alteracao
            return $arrProduto;
        }
    }

    public function excluir($id)
    {
        $produtos = $this->listar();
        $chave = array_search($id, array_column($produtos, 'id'));
        unset($produtos[$chave]);
        return $produtos;
    }

    public function listar()
    {
        $produtos = array(
             array('id' => 1,'nome' => 'nome do produto 1','descricao' => 'descricao do produto 1','valor' => 11),
             array('id' => 2,'nome' => 'nome do produto 2','descricao' => 'descricao do produto 2','valor'=>22),
             array('id' => 3,'nome' => 'nome do produto 3','descricao' => 'descricao do produto 3','valor'=>33),
             array('id' => 4,'nome' => 'nome do produto 4','descricao' => 'descricao do produto 4','valor'=>44),
             array('id' => 5,'nome' => 'nome do produto 5','descricao' => 'descricao do produto 5','valor'=>55),
             array('id' => 6,'nome' => 'nome do produto 6','descricao' => 'descricao do produto 6','valor'=>66),
             array('id' => 7,'nome' => 'nome do produto 7','descricao' => 'descricao do produto 7','valor'=>77),
             array('id' => 8,'nome' => 'nome do produto 8','descricao' => 'descricao do produto 8','valor'=>88),
             array('id' => 9,'nome' => 'nome do produto 9','descricao' => 'descricao do produto 9','valor'=>99),
             array('id' => 10,'nome' => 'nome do produto 10','descricao' => 'descricao do produto 10','valor'=>101),
        );
        return $produtos;
    }
    public function objectToArray(ProdutoEntity $produto)
    {
        return array(
            'id' => $produto->getId(),
            'nome' => $produto->getNome(),
            'descricao'=> $produto->getDescricao(),
            'valor' => $produto->getValor(),
        );
    }
}
