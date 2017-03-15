<?php

namespace JP\Sistema\Mapper;

use JP\Sistema\Entity\ClienteEntity;

class ClienteMapper
{
    public function gravar(ClienteEntity $cliente)
    {
        $clientes = $this->listar();
        $arrCliente = $this->objectToArray($cliente);
        if (empty($arrCliente['id'])) { //Inclusão
            return array_push($clientes, $arrCliente);
        } else { //alteracao
            return arrCliente['nome'].' ALTERADO';
        }
    }

    public function excluir($id)
    {
        $clientes = $this->listar();
        $chave = array_search($id, array_column($clientes, 'id'));
        unset($clientes[$chave]);
        return $clientes;
    }

    public function listar()
    {
        $clientes = array(
             array('id'=>1,'nome'=>'Nome do Cliente 1','email'=>'Email do Cliente 1','cpf'=>'11111111111'),
             array('id'=>2,'nome'=>'Nome do Cliente 2','email'=>'Email do Cliente 2','cpf'=>'22222222222'),
             array('id'=>3,'nome'=>'Nome do Cliente 3','email'=>'Email do Cliente 3','cpf'=>'33333333333'),
             array('id'=>4,'nome'=>'Nome do Cliente 4','email'=>'Email do Cliente 4','cpf'=>'44444444444'),
             array('id'=>5,'nome'=>'Nome do Cliente 5','email'=>'Email do Cliente 5','cpf'=>'55555555555'),
             array('id'=>6,'nome'=>'Nome do Cliente 6','email'=>'Email do Cliente 6','cpf'=>'66666666666'),
             array('id'=>7,'nome'=>'Nome do Cliente 7','email'=>'Email do Cliente 7','cpf'=>'77777777777'),
             array('id'=>8,'nome'=>'Nome do Cliente 8','email'=>'Email do Cliente 8','cpf'=>'88888888888'),
             array('id'=>9,'nome'=>'Nome do Cliente 9','email'=>'Email do Cliente 9','cpf'=>'99999999999'),
             array('id'=>10,'nome'=>'Nome do Cliente 10','email'=>'Email do Cliente 10','cpf'=>'10101010101'),
        );
        return $clientes;
    }

    public function objectToArray(ClienteEntity $cliente)
    {
        return array(
            'id' =>$cliente->getId(),
            'nome' =>$cliente->getNome(),
            'email' =>$cliente->getEmail(),
            'cpf'=>null,
        );
    }
}
