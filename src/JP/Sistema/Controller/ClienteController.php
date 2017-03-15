<?php

namespace JP\Sistema\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JP\Sistema\Service\ClienteService;
use JP\Sistema\Entity\ClienteEntity;
use JP\Sistema\Mapper\ClienteMapper;

class ClienteController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $ctrl = $app['controllers_factory'];

        $app['cliente_service'] = function () {
            $ent = new \JP\Sistema\Entity\ClienteEntity();
            $map = new \JP\Sistema\Mapper\ClienteMapper();
            return new \JP\Sistema\Service\ClienteService($ent, $map);
        };

        $ctrl->get('/', function () use ($app) {
            return $app['twig']->render('cliente_inicio.twig');
        })->bind('indexCliente');

        $ctrl->get('/incluir', function () use ($app) {
            return $app['twig']->render('cliente_cadastro.twig', array('cliente'=>null));
        })->bind('incluirCliente');

        $ctrl->get('/alterar/{id}', function (Request $req, $id) use ($app) {
            $srv = $app['cliente_service'];
            $clientes = $srv->listar();
            $chave = array_search($id, array_column($clientes, 'id'));
            if (!isset($chave)) {
                return $app->abort(500, "Não encontrei o cliente {$id}");
            }
            return $app['twig']->render('cliente_cadastro.twig', array('cliente'=>$clientes[$chave]));
        })->bind('alterarCliente');

        $ctrl->post('/gravar', function (Request $req) use ($app) {
            $dados = $req->request->all();
            $srv = $app['cliente_service'];
            $clientes = $srv->gravar($dados);
            return $app['twig']->render('cliente_lista.twig', array('clientes'=>$clientes));
        })->bind('gravarCliente');

        $ctrl->get('/excluir/{id}', function (Request $req, $id) use ($app) {
            $srv = $app['cliente_service'];
            $clientes = $srv->listar();
            $chave = array_search($id, array_column($clientes, 'id'));
            if (!isset($chave)) {
                return $app->abort(500, "Não encontrei o cliente {$id}");
            }
            unset($clientes[$chave]); //remove o $id
            return $app['twig']->render('cliente_lista.twig', array('clientes'=>$clientes));
        })->bind('excluirCliente');

        $ctrl->get('/listar/html', function () use ($app) {
            return $app['twig']->render('cliente_lista.twig', ['clientes'=>$app['cliente_service']->listar()]);
        })->bind('listarClienteHtml');

        $ctrl->get('/listar/json', function () use ($app) {
            return new Response($app->json($app['cliente_service']->listar()), 201);
        })->bind('listarClienteJson');

        return $ctrl;
    }
}
