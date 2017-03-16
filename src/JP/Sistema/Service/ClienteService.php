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

    public function insert(array $dados)
    {
        $this->ent->setNome($dados['nomCliente']);
        $this->ent->setDescricao($dados['emlCliente']);
        if (isset($dados['nomCliente'])&&
            isset($dados['emlCliente'])) {
            return $this->map->gravar($this->ent);
        } else {
            return array('sucess' => false, );
        }
    }

    public function update(int $id, array $dados)
    {
        $this->ent->setId($id);
        $this->ent->setNome($dados['nomCliente']);
        $this->ent->setDescricao($dados['emlCliente']);
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
