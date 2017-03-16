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
        //aplicacao
        $ctrl->get('/', function () use ($app) {
            return $app['twig']->render('produto_inicio.twig');
        })->bind('indexProduto');

        $ctrl->get('/incluir', function (Request $req) use ($app) {
            return $app['twig']->render('produto_cadastro.twig', array('produto'=>null));
        })->bind('incluirProduto');

        $ctrl->get('/alterar/{id}', function (Request $req, $id) use ($app) {
            $dados = $req->request->all();
            $srv = $app['produto_service'];
            $produtos = $srv->update($id, $dados);
            $chave = array_search($id, array_column($produtos, 'id'));
            if (!isset($chave)) {
                return $app->abort(500, "Não encontrei o produto {$id}");
            }
            return $app['twig']->render('produto_cadastro.twig', array('produto'=>$produtos[$chave]));
        })->bind('alterarProduto')
        ->assert('id', '\d+');

        $ctrl->post('/gravar', function (Request $req) use ($app) {
            $dados = $req->request->all();
            $srv = $app['produto_service'];
            $produtos = $srv->insert($dados);
            return $app->redirect($app['url_generator']->generate('listarProdutoHtml'));
        })->bind('gravarProduto');

        $ctrl->get('/excluir/{id}', function ($id) use ($app) {
            $srv = $app['produto_service'];
            $produtos = $srv->fetchall();
            $chave = array_search($id, array_column($produtos, 'id'));
            if (!isset($chave)) {
                return $app->abort(500, "Não encontrei o produto {$id}");
            }
            unset($produtos[$chave]); //remove o $id
            return $app->redirect($app['url_generator']->generate('listarProdutoHtml'));
        })->bind('excluirProduto')
        ->assert('id', '\d+');

        $ctrl->get('/listar/html', function () use ($app) {
            return $app['twig']->render('produto_lista.twig', ['produtos'=>$app['produto_service']->fetchall()]);
        })->bind('listarProdutoHtml');
        
        //api
        $ctrl->get('/api/listar/json', function () use ($app) {
            $srv = $app['produto_service'];
            $produtos = $srv->fetchall();
            return $app->json($produtos);
        })->bind('listarProdutoJson');

        $ctrl->get('/api/listar/{id}', function ($id) use ($app) {
            $srv = $app['produto_service'];
            $produtos = $srv->fetchall();
            $chave = array_search($id, array_column($produtos, 'id'));
            return $app->json($produtos[$chave]);
        })->bind('listarProdutoIdJson');

        $ctrl->post('/api/inserir', function (Request $req) use ($app) {
            $dados = $req->request->all();
            $srv = $app['produto_service'];
            $produtos = $srv->insert($dados);
            return $app->json($produtos);
        })->bind('inserirProdutoJson');

        $ctrl->put('/api/atualizar/{id}', function (Request $req, $id) use ($app) {
            $dados = $req->request->all();
            $srv = $app['produto_service'];
            $produtos = $srv->update($id, $dados);
            return $app->json($produtos[$chave]);
        })->bind('atualizarProdutoJson');

        $ctrl->delete('/api/apagar/{id}', function ($id) use ($app) {
            $srv = $app['produto_service'];
            $produtos = $srv->delete($id);
            return $app->json($produtos[$id]);
        })->bind('apagarProdutoJson');

        return $ctrl;
    }
}
