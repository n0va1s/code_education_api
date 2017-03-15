<?php

namespace JP\Sistema\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JP\Sistema\Service\ProdutoService;
use JP\Sistema\Entity\ProdutoEntity;
use JP\Sistema\Mapper\ProdutoMapper;

class ProdutoController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $ctrl = $app['controllers_factory'];

        $app['produto_service'] = function () {
            $ent = new \JP\Sistema\Entity\ProdutoEntity();
            $map = new \JP\Sistema\Mapper\ProdutoMapper();
            return new \JP\Sistema\Service\ProdutoService($ent, $map);
        };

        $ctrl->get('/', function () use ($app) {
            return $app['twig']->render('produto_inicio.twig');
        })->bind('indexProduto');

        $ctrl->get('/incluir', function (Request $req) use ($app) {
            return $app['twig']->render('produto_cadastro.twig', array('produto'=>null));
        })->bind('incluirProduto');

        $ctrl->get('/alterar/{id}', function ($id) use ($app) {
            $srv = $app['produto_service'];
            $produtos = $srv->listar();
            $chave = array_search($id, array_column($produtos, 'id'));
            if (!isset($chave)) {
                return $app->abort(500, "Não encontrei o produto {$id}");
            }
            return $app->json($produtos[$chave]);
        })->bind('alterarProduto')
        ->assert('id', '\d+');

        $ctrl->post('/gravar', function (Request $req) use ($app) {
            $dados = $req->request->all();
            $srv = $app['produto_service'];
            $produtos = $srv->gravar($dados);
            return $app->redirect($app['url_generator']->generate('listarProdutoHtml'));
        })->bind('gravarProduto');

        $ctrl->get('/excluir/{id}', function ($id) use ($app) {
            $srv = $app['produto_service'];
            $produtos = $srv->listar();
            $chave = array_search($id, array_column($produtos, 'id'));
            if (!isset($chave)) {
                return $app->abort(500, "Não encontrei o produto {$id}");
            }
            unset($produtos[$chave]); //remove o $id
            return $app->redirect($app['url_generator']->generate('listarProdutoHtml'));
        })->bind('excluirProduto')
        ->assert('id', '\d+');

        $ctrl->get('/listar/html', function () use ($app) {
            return $app['twig']->render('produto_lista.twig', ['produtos'=>$app['produto_service']->listar()]);
        })->bind('listarProdutoHtml');

        $ctrl->get('/listar/json', function () use ($app) {
            $srv = $app['produto_service'];
            $produtos = $srv->listar();
            return $app->json($produtos);
        })->bind('listarProdutoJson');

        return $ctrl;
    }
}
