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

    public function gravar(array $dados)
    {
        if ($dados['id']) { //Para alteracao
            $this->ent->setId($dados['id']);
        }
        $this->ent->setNome($dados['nome']);
        $this->ent->setDescricao($dados['descricao']);
        $this->ent->setValor($dados['valor']);
        return $this->map->gravar($this->ent);
    }

    public function listar()
    {
        return $this->map->listar();
    }
}
