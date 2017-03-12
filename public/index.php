<?php
require __DIR__.'/../bootstrap.php';

use Symfony\Component\HttpFoundation\Response;

$clientes = array(
    array('nome'=>'Nome do Cliente 1','email'=>'Email do Cliente 1','cpf'=>'11111111111'),
    array('nome'=>'Nome do Cliente 2','email'=>'Email do Cliente 2','cpf'=>'22222222222'),
    array('nome'=>'Nome do Cliente 3','email'=>'Email do Cliente 3','cpf'=>'33333333333'),
    array('nome'=>'Nome do Cliente 4','email'=>'Email do Cliente 4','cpf'=>'44444444444'),
    array('nome'=>'Nome do Cliente 5','email'=>'Email do Cliente 5','cpf'=>'55555555555'),
    array('nome'=>'Nome do Cliente 6','email'=>'Email do Cliente 6','cpf'=>'66666666666'),
    array('nome'=>'Nome do Cliente 7','email'=>'Email do Cliente 7','cpf'=>'77777777777'),
    array('nome'=>'Nome do Cliente 8','email'=>'Email do Cliente 8','cpf'=>'88888888888'),
    array('nome'=>'Nome do Cliente 9','email'=>'Email do Cliente 9','cpf'=>'99999999999'),
    array('nome'=>'Nome do Cliente 10','email'=>'Email do Cliente 10','cpf'=>'10101010101'),
);

$app->get('/', function () {
    return new Response('Bem-vindo ao módulo Api/Silex', 200);
});

$app->get('/clientes', function () use ($app, $clientes) {
    return new Response($app->json($clientes), 201);
});

$app->run();
