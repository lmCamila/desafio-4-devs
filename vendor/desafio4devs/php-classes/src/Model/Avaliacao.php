<?php 
namespace Devs\Model;

use Devs\Model\Cliente;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Avaliacao{

	private function accessDB(){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/google-service-account.json');

		$firebase = (new Factory)
		    ->withServiceAccount($serviceAccount)
		    ->withDatabaseUri('https://desafio-4-devs-forlogic.firebaseio.com/')
		    ->create();
	    return $firebase;
	}

	public function addAvaliacao($data , $cliente , $nota , $motivo){
		$firebase = $this->accessDB();
		$database = $firebase->getDatabase();

		$database->getReference('avaliação')
	   		->push([
	       'data' => $data,
	       'cliente' => $cliente,
	       'nota'=>$nota,
	       'motivo'=>$motivo
	      ]);
	}

	public function buscarAvaliaçãoPorCliente($cliente){
		$firebase = $this->accessDB();
		$database = $firebase->getDatabase();
		$results[]=$database->getReference('avaliação')->orderByChild('cliente')->equalTo($cliente)->getSnapshot()->getValue();
		$args = $results[0];
		return $args;
	}

	public function buscarAvaliacaoPorData($data){
		$firebase = $this->accessDB();
		$database = $firebase->getDatabase();
		$results[]=$database->getReference('avaliação')->orderByChild('data')->equalTo($data)->getSnapshot()->getValue();
		$args = $results[0];
		return $args;
	}

	public function buscarTodasAvaliacoes(){
		$firebase = $this->accessDB();
		$database = $firebase->getDatabase();
		$results[]=$database->getReference('avaliação')->getSnapshot()->getValue();
		$args = $results[0];
		return $args;
	}
	public function mudarClassificaçãoCliente($empresa,$nota){
		$firebase = $this->accessDB();
		$database = $firebase->getDatabase();
		$classificacao = NULL;
		if($nota === '0'||$nota === '1'||$nota === '2'||$nota === '3'||$nota === '4'||$nota === '5'||$nota === '6'){
			$classificacao = "Detrator";
		}elseif ($nota === '7'||$nota === '8') {
			$classificacao = "Neutro";
		}elseif ($nota === '9'||$nota === '10') {
			$classificacao = "Promotor";
		}
		$cliente = new Cliente();
		$chave = $cliente->buscarChaveCliente($empresa);
		$updates = [
		    'clientes/'.$chave.'/classificação' => $classificacao
		];

		$database->getReference()->update($updates);
		
	}

	public function validarClienteAvaliação($cliente,$data_referencia){
		$results = $this->buscarAvaliaçãoPorCliente($cliente);
		$mes=0;$mes1;$ano=0;$ano1;
		foreach ($results as $key => $value) {
			if(strcmp($value['data'],$data_referencia) === 0 ){
				throw new \Exception("O cliente ja participou  da avaliação neste mês.");
			}
			$ano1 = (int)substr($value['data'],0,4);
			$mes1 = (int)substr($value['data'], 5,strlen($value['data']));
			if($ano1 > $ano){
				$ano = $ano1;
				$mes = $mes1;
			}elseif($mes1 > $mes){
				$mes = $mes1;
			}
		}
		if($mes === 11){
			$str1 = $ano."-".($mes1 + 1);
			$str2 = ($ano+1)."-".(01);
			$str3 = $ano."-".$mes;
			if(strcmp($data_referencia, $str1) === 0 || strcmp($data_referencia, $str2) === 0 || strcmp($data_referencia, $str3) === 0){
				throw new \Exception("O periodo para que o cliente possa participar novamente da avaliação ainda não terminou.");
			}		
		}elseif ($mes === 12) {
			$str1 = ($ano+1)."-".(01);
			$str2 = ($ano+1)."-".(02);
			$str3 = $ano."-".$mes;;
			if(strcmp($data_referencia, $str1) === 0 || strcmp($data_referencia, $str2) === 0 || strcmp($data_referencia, $str3) === 0){
				throw new \Exception("O periodo para que o cliente possa participar novamente da avaliação ainda não terminou.");
			}	
		}else{
			if($mes =! 9){
				$str1 = $ano."-0".($mes + 1);
				$str2 = $ano."-0".($mes + 2);
				$str3 = $ano."-0".$mes;;
			}else{
				$str1 = $ano."-".($mes + 1);
				$str2 = $ano."-".($mes + 2);
				$str3 = $ano."-0".$mes;
			}
			if(strcmp($data_referencia, $str1) === 0 || strcmp($data_referencia, $str2) === 0 || strcmp($data_referencia, $str3) === 0){
				throw new \Exception("O periodo para que o cliente possa participar novamente da avaliação ainda não terminou.");
			}
		}
	}
	public function calcularDados($data){
		$promotor = 0;
		$neutro = 0 ;
		$detrator = 0;
		$participantes=0;
		$array = $this->buscarAvaliacaoPorData($data);
			
	     foreach ($array as $key => $value) {
	        
		    if($value['nota'] === '0'||$value['nota'] === '1'||$value['nota'] === '2'||$value['nota'] === '3'||$value['nota'] === '4'||$value['nota'] === '5'||$value['nota'] === '6'){
				$detrator++;
				$participantes++;
			}elseif ($value['nota'] === '7'||$value['nota'] === '8') {
				$neutro++;
				$participantes++;
			}elseif ($value['nota'] === '9'||$value['nota'] === '10') {
				$promotor++;
				$participantes++;
			}
	    }
		if($participantes===0){
			$participantes = 1;
			$nps=(($promotor-$detrator)/$participantes)*100;
		}else{
			$nps=(($promotor-$detrator)/$participantes)*100;
		}
		$results=array('promotores'=>$promotor,'detratores'=>$detrator,'neutros'=>$neutro,'NPS'=>$nps);
		return $results;
	}

}

 ?>
