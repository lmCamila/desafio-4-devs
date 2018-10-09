<?php 

use Devs\Page;
use Devs\Model\Cliente;
use Slim\Http\Request;
use \Psr\Http\Message\ServerRequestInterface as Requests;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/clientes',function(){
    $cliente = new Cliente();
    $array = $cliente->buscarTodosClientes();
    $data=array();

    foreach ($array as $key => $value) {
        $aux = array(
        'chave'=>$value['chave'],
        'cliente'=>$value['empresa'],
        'nome_contato'=>$value['nome do contato'],
        'data'=>$value['data de cadastro'],
        'classificacao'=>$value['classificação'],
        'status'=>$value['status']);
       array_push($data,$aux);
    }
    $array = array("data"=>$data);

    $page = new Page();

    $page->setTpl("clientes",$array);

});

$app->get('/clientes/cadastrar',function(){
    
    $page = new Page();

    $page->setTpl("cadastrar-clientes");

});

$app->post('/clientes/cadastrar',function(){
    try {
        $cliente = new Cliente();

        $cliente->addCliente($_POST['cliente'],$_POST['nome_contato'],$_POST['data'],$_POST['status']);

        header("Location: /clientes");

        exit();
    } catch (Exception $e) {
        echo   $e->getMessage();
    }
});

$app->get('/clientes/alterar/{chave}',function(Requests $request, Response $response, array $args){
    $cliente = new Cliente();
    $array = $cliente->buscarCliente($args['chave']);
    $data = array('data'=>array(
        'chave'=>$array['chave'],
        'cliente'=>$array['empresa'],
        'nome_contato'=>$array['nome do contato'],
        'data'=>$array['data de cadastro'],
        'status'=>$array['status']));
    $page = new Page();
    $page->setTpl("alterar-clientes",$data);

});

$app->post('/clientes/alterar/{chave}',function(Requests $request, Response $response, array $args){
    $cliente = new Cliente();

    $cliente->updateCliente($args['chave'],$_POST['cliente'],$_POST['nome_contato'],$_POST['data'],$_POST['status']);

    header("Location: /clientes");

    exit();
});

$app->get('/clientes/{chave}/deletar',function(Requests $request, Response $response, array $args){
    $cliente = new Cliente();
    $cliente->deleteCliente($args['chave']);
    header("Location: /clientes");
    exit();
});

 ?>