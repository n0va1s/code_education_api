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
            return new Response('Aqui vc pode administrar os dados do cliente: <br />
            	/cadastro/{nome} - monstra as informações de um cliente <br />
            	/lista/html - apresenta todos os clientes cadastrados em uma lista  <br />
            	/lista/json - apresenta todos os clientes cadastrados em formato json  <br />', 200);
        })->bind('indexCliente');

        $ctrl->get('/cadastro/{nome}', function ($nome) use ($app) {
            if (isset($nome)) {
                $dados['nome'] = "{$nome}";
                $dados['email'] = "{$nome}@cliente.com";
                $result = $app['cliente_service']->inserir($dados);
                return $app->json($result);
            } else {
                return $app->abort(500, "Informe um nome!");
            }
        })->bind('cadastroCliente');

        $ctrl->get('/lista/html', function () use ($app) {
            return $app['twig']->render('cliente_lista.twig', ['clientes'=>$app['cliente_service']->listar()]);
        })->bind('listaClientesHtml');

        $ctrl->get('/lista/json', function () use ($app) {
            return new Response($app->json($app['cliente_service']->listar()), 201);
        })->bind('listaClientesJson');

        return $ctrl;
    }
}
