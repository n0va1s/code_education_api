<?php

namespace JP\Sistema\Service;

use JP\Sistema\Entity\ClienteEntity;
use JP\Sistema\Mapper\ClienteMapper;

class ClienteService {

	private $ent;
	private $map;

	public function __construct(ClienteEntity $ent, ClienteMapper $map) {
		$this->ent = $ent;
		$this->map = $map;
	}

	public function inserir (array $dados) {
		$this->ent->setNome($dados['nome']);
		$this->ent->setEmail($dados['email']);
		return $this->map->inserir($this->ent);
	}

	public function listar () {
		return $this->map->listar();
	}
}