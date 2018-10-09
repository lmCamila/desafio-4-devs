<?php
session_start();

require_once("vendor/autoload.php");

use Devs\Page;
use Devs\Model\Avaliacao;
use Devs\Model\Cliente;
use Slim\Http\Request;
use \Psr\Http\Message\ServerRequestInterface as Requests;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

require_once("indexCliente.php");

require_once("functions.php");

$app->get('/',function(){
    $avaliacao = new Avaliacao();
    $array = $avaliacao->buscarTodasAvaliacoes();
    $data=array();
     foreach ($array as $key => $value) {
        $aux = array(
        'data'=>$value['data']
        );
        $dataNova = $value;
        array_push($data,$aux);
    }
    $newData = array();
    foreach ($data as $key => $value) {
        if(array_search($value ,$newData)===FALSE){
            $newData = array(
            'data'=>$value
            );
        }        
    }
    $recursos = array("data"=>$newData);
    $page = new Page();

    $page->setTpl("index",$recursos);
});
$app->post('/',function(){
    $str = "Location: /resultados/".$_POST['data'];
     header($str);

    exit();
});
$app->get('/resultados/{data}',function(Requests $request, Response $response, array $args){
    $avaliacao = new Avaliacao();
    $array = $avaliacao->calcularDados($args['data']);
    $data = array('data'=>array(
        'data'=>$args['data'],
        'detratores'=>$array['detratores'],
        'neutros'=>$array['neutros'],
        'promotores'=>$array['promotores'],
        'nps'=>$array['NPS']
    ));
    $page = new Page();

    $page->setTpl("resultados",$data);
});

$app->get('/avaliacoes',function(){
    $cliente = new Cliente();
    $array = $cliente->buscarTodosClientes();
    $data=array();
     foreach ($array as $key => $value) {
        $aux = array(
        'cliente'=>$value['empresa']
        );
       array_push($data,$aux);
    }
    $array = array("data"=>$data);
    $page = new Page();

    $page->setTpl("avaliacao",$array);

});


$app->post('/avaliacoes',function(){
    try {
    $avaliacao = new Avaliacao();
    $avaliacao->validarClienteAvaliação($_POST['cliente'],$_POST['data']);
    $avaliacao->addAvaliacao($_POST['data'],$_POST['cliente'],$_POST['nota'],$_POST['motivo_nota']);

    $avaliacao->mudarClassificaçãoCliente($_POST['cliente'],$_POST['nota']);

    exit();
    } catch (Exception $e) {
    echo $e->getMessage();
    exit();
    } finally {
       header("Location: /avaliacoes"); 
       exit();
    }
});

$app->run();
?>