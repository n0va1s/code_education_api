<?php
require __DIR__.'/../bootstrap.php';

use Symfony\Component\HttpFoundation\Response;
use JP\Sistema\Service\ClienteService;
use JP\Sistema\Entity\ClienteEntity;
use JP\Sistema\Mapper\ClienteMapper;

$app['cliente_service'] = function () {
    $ent = new JP\Sistema\Entity\ClienteEntity();
    $map = new JP\Sistema\Mapper\ClienteMapper();
    return new JP\Sistema\Service\ClienteService($ent, $map);
};

$app->get('/', function () use ($app) {
    return $app['twig']->render('inicio.twig');
})->bind('inicio');


$app->get('/cliente', function () use ($app) {
    $dados['nome'] = 'Cliente X';
    $dados['email'] = 'emailx@gmail.com';
    $result = $app['cliente_service']->inserir($dados);
    return $app->json($result);
})->bind('cadastroCliente');

$app->get('/clientes/html', function () use ($app) {
    return $app['twig']->render('cliente_lista.twig', ['clientes'=>$app['cliente_service']->listar()]);
})->bind('listaClientesHtml');

$app->get('/clientes/json', function () use ($app) {
    return new Response($app->json($app['cliente_service']->listar()), 201);
})->bind('listaClientesJson');

$app->run();
