<?php

namespace JP\Sistema\Service;

use JP\Sistema\Entity\ProdutoEntity;
use JP\Sistema\Mapper\ProdutoMapper;

class ProdutoService
{
    private $ent;
    private $map;

    public function __construct(ProdutoEntity $ent, ProdutoMapper $map)
    {
        $this->ent = $ent;
        $this->map = $map;
    }

    public function insert(array $dados)
    {
        $this->ent->setNome($dados['nomProduto']);
        $this->ent->setDescricao($dados['desProduto']);
        $this->ent->setValor($dados['valProduto']);
        if (isset($dados['nomProduto'])&&
            isset($dados['desProduto'])&&
            isset($dados['valProduto'])) {
            return $this->map->gravar($this->ent);
        } else {
            return array('sucess' => false, );
        }
    }

    public function update(int $id, array $dados)
    {
        $this->ent->setId($id);
        $this->ent->setNome($dados['nomProduto']);
        $this->ent->setDescricao($dados['desProduto']);
        $this->ent->setValor($dados['valProduto']);
        if (isset($id)) {
            return $this->map->gravar($this->ent);
        } else {
            return array('sucess' => false, );
        }
    }

    public function delete(int $id)
    {
        $this->ent->setId($id);
        return $this->map->excluir($this->ent);
    }

    public function fetchall()
    {
        return $this->map->listar();
    }
}
