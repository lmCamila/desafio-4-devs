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

/*$app->get('/',function(){
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
});*/

$app->get('/resultados',function(){
    $avaliacao = new Avaliacao();
    $data= $avaliacao->buscarDatas();

    $resultados = array();
    foreach ($data as $key => $value) {
        $array = $avaliacao->calcularDados($value);
        $src = array(
        'data'=>$value,
        'detratores'=>$array['detratores'],
        'neutros'=>$array['neutros'],
        'promotores'=>$array['promotores'],
        'nps'=>$array['NPS'],
        'marcador'=>$array['marcador']
        );
        array_push($resultados, $src);
    }
    $results = array('value'=>$resultados);

    $page = new Page();

    $page->setTpl("resultados",$results);

});

$app->get('/resultados/{data}',function(Requests $request, Response $response, array $args){
    $avaliacao = new Avaliacao();
    $array = $avaliacao->calcularDados($args['data']);
    $avaliacoes = $avaliacao->buscarAvaliacaoPorData($args['data']);
    $results=array();
    
     foreach ($avaliacoes as $key => $value) {
        $aux = array(
        'cliente'=>$value['cliente'],
        'nota'=>$value['nota'],
        'motivo'=>$value['motivo'],
        'data'=>$value['data']
        );
       array_push($results,$aux);
    }

    $data = array('data'=>array(
        'data'=>$args['data'],
        'detratores'=>$array['detratores'],
        'neutros'=>$array['neutros'],
        'promotores'=>$array['promotores'],
        'nps'=>$array['NPS'],
        'marcador'=>$array['marcador']),
        'value'=>$results
    );


    $page = new Page();

    $page->setTpl("resultados-por-mes",$data);
});

$app->get('/avaliacoes',function(){
    $avaliacao = new Avaliacao();
    $array = $avaliacao->buscarTodasAvaliacoes();
     $data=array();
    
     foreach ($array as $key => $value) {
        $aux = array(
        'cliente'=>$value['cliente'],
        'nota'=>$value['nota'],
        'motivo'=>$value['motivo'],
        'data'=>$value['data']
        );
       array_push($data,$aux);
    }

    $date = $avaliacao->retornaDataAtual();
    $array = array("data"=>$data,
    "dataAtual"=>$date,
    "porcentagem"=>$avaliacao->calcularAvaliacoes($date));
   
    $page = new Page();

    $page->setTpl("avaliacao",$array);
});

$app->get('/avaliacoes/nova',function(){
    $cliente = new Cliente();
    $avaliacao = new Avaliacao();
    if($avaliacao->calcularAvaliacoes($avaliacao->retornaDataAtual()) >= 100){
        header("Location: /avaliacoes/concluidas"); 
        exit();
    }
    $array = $cliente->buscarTodosClientes();

    $data=array();
  
     foreach ($array as $key => $value) {
        if($avaliacao->validarClienteAvaliação($value['empresa'],$avaliacao->retornaDataAtual())){
           $aux = array(
            'cliente'=>$value['empresa']
            );
            array_push($data,$aux);
        }    
    }
   
    $array = array("value"=>$data,
    "date" => $avaliacao->retornaDataAtual());
    $page = new Page();

    $page->setTpl("nova-avaliacao",$array);

});

$app->post('/avaliacoes/nova',function(){
    $avaliacao = new Avaliacao();
    $avaliacao->addAvaliacao($avaliacao->retornaDataAtual(),$_POST['cliente'],$_POST['nota'],$_POST['motivo_nota']);

    $avaliacao->mudarClassificaçãoCliente($_POST['cliente'],$_POST['nota']);
    header("Location: /avaliacoes"); 
    exit();
    
});
$app->get('/avaliacoes/concluidas',function(){
    $page = new Page();

    $page->setTpl("todas-avaliacoes-ok");
});



$app->run();
?>