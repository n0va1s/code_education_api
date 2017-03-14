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
            return new Response('Aqui vc pode administrar os dados do produto: <br />
            	/incluir - apresenta o formulário de inclusão de um produto <br />
            	/alterar/{id} - apresenta o produto do array (alterado)<br />
                /excluir/{id} - exclui um produto do array<br />
            	/listar - apresenta todos os clientes cadastrados em uma lista  <br /> ', 200);
        })->bind('indexProduto');

        $ctrl->get('/incluir', function () use ($app) {
            $dados = array('nome' => 'Xbox 360',
                           'descricao'=>'O último lançamento da Microsoft para jogos',
                           'valor'=>999.97);
            $srv = $app['produto_service'];
            $produto = $srv->gravar($dados);
            if (!empty($produto)) {
                return $app->json($produto);
            } else {
                $app->abort(501, "Não foi possível cadastrar o produto :(");
            }
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

        $ctrl->get('/excluir/{id}', function ($id) use ($app) {
            $srv = $app['produto_service'];
            $produtos = $srv->listar();
            $chave = array_search($id, array_column($produtos, 'id'));
            if (!isset($chave)) {
                return $app->abort(500, "Não encontrei o produto {$id}");
            }
            unset($produtos[$chave]); //remove o $id
            return $app->json($produtos);
        })->bind('excluirProduto')
        ->assert('id', '\d+');

        $ctrl->get('/listar', function () use ($app) {
            $srv = $app['produto_service'];
            $produtos = $srv->listar();
            return $app->json($produtos);
        })->bind('listarProdutos');

        return $ctrl;
    }
}
