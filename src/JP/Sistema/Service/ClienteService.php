<?php

namespace JP\Sistema\Service;

use JP\Sistema\Entity\ClienteEntity;
use JP\Sistema\Mapper\ClienteMapper;

class ClienteService
{
    private $ent;
    private $map;

    public function __construct(ClienteEntity $ent, ClienteMapper $map)
    {
        $this->ent = $ent;
        $this->map = $map;
    }

    public function gravar(array $dados)
    {
        if ($dados['id']) { //Para alteracao
            $this->ent->setId($dados['id']);
        }
        $this->ent->setNome($dados['nomCliente']);
        $this->ent->setEmail($dados['emlCliente']);
        return $this->map->gravar($this->ent);
    }

    public function listar()
    {
        return $this->map->listar();
    }
}
