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
		    if((int)$nota <= 6){
				$classificacao = "Detrator";
			}elseif ((int)$nota > 6 && $nota <= 8) {
				$classificacao = "Neutro";
			}elseif ((int)$nota >= 9) {
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
				//throw new \Exception("O cliente ja participou  da avaliação neste mês.");
				return false;
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
				//throw new \Exception("O periodo para que o cliente possa participar novamente da avaliação ainda não terminou.");
				return false;
			}		
		}elseif ($mes === 12) {
			$str1 = ($ano+1)."-".(01);
			$str2 = ($ano+1)."-".(02);
			$str3 = $ano."-".$mes;;
			if(strcmp($data_referencia, $str1) === 0 || strcmp($data_referencia, $str2) === 0 || strcmp($data_referencia, $str3) === 0){
				//throw new \Exception("O periodo para que o cliente possa participar novamente da avaliação ainda não terminou.");
				return false;
			}	
		}elseif($mes < 11){
			if($mes != 8){
				$str1 = $ano."-0".($mes + 1);
				$str2 = $ano."-0".($mes + 2);
				$str3 = $ano."-0".$mes;
				if(strcmp($data_referencia, $str1) === 0 || strcmp($data_referencia, $str2) === 0 || strcmp($data_referencia, $str3) === 0){
				//throw new \Exception("O periodo para que o cliente possa participar novamente da avaliação ainda não terminou.");
				return false;
			}
			}
			if($mes === 8){
				$str1 = $ano."-0".($mes + 1);
				$str2 = $ano."-".($mes + 2);
				$str3 = $ano."-0".$mes;
				if(strcmp($data_referencia, $str1) === 0 || strcmp($data_referencia, $str2) === 0 || strcmp($data_referencia, $str3) === 0){
				//throw new \Exception("O periodo para que o cliente possa participar novamente da avaliação ainda não terminou.");
				return false;
			}
			}
			if($mes === 9){
				$str1 = $ano."-".($mes + 1);
				$str2 = $ano."-".($mes + 2);
				$str3 = $ano."-0".$mes;
				if(strcmp($data_referencia, $str1) === 0 || strcmp($data_referencia, $str2) === 0 || strcmp($data_referencia, $str3) === 0){
				//throw new \Exception("O periodo para que o cliente possa participar novamente da avaliação ainda não terminou.");
				return false;
			}
			}
			if($mes === 10){
				$str1 = $ano."-".($mes + 1);
				$str2 = $ano."-".($mes + 2);
				$str3 = $ano."-".$mes;
				if(strcmp($data_referencia, $str1) === 0 || strcmp($data_referencia, $str2) === 0 || strcmp($data_referencia, $str3) === 0){
				//throw new \Exception("O periodo para que o cliente possa participar novamente da avaliação ainda não terminou.");
				return false;
			}
			}
			
		}
		return true;
	}
	public function calcularDados($data){
		$promotor = 0;
		$neutro = 0 ;
		$detrator = 0;
		$participantes=0;
		$marcador;
		$array = $this->buscarAvaliacaoPorData($data);
			
	     foreach ($array as $key => $value) {
	        $nota = (int)$value['nota'];
		    if($nota <= 6){
				$detrator++;
				$participantes++;
			}elseif ($nota > 6 && $nota <= 8) {
				$neutro++;
				$participantes++;
			}elseif ($nota >= 9) {
				$promotor++;
				$participantes++;
			}
	    }
		if($participantes===0){
			throw new \Exception("Erro, não há participantes");
			
		}else{
			$nps=(($promotor-$detrator)/$participantes)*100;
			if($nps>=80){
				$marcador = "table-success";
			}elseif($nps < 80 && $nps >= 60){
				$marcador = "table-warning";
			}elseif($nps < 60){
				$marcador = "table-danger";
			}
		}
		$results=array('promotores'=>$promotor,'detratores'=>$detrator,'neutros'=>$neutro,'NPS'=>$nps,'marcador'=>$marcador);
		return $results;
	}

	public function calcularAvaliacoes($data){
		$cliente = new Cliente();
		$pc =  (count($this->buscarAvaliacaoPorData($data))*100)/(count($cliente->buscarTodosClientes())*0.2);
		return $pc;
	}

	public function retornaDataAtual(){
		$today = getdate();
		$mes = $today["mon"];
		$ano = $today["year"];
		if($mes <= 9){
			return $ano."-0".$mes;
		}else{
			return $ano."-".($mes);
		}
	}
	public function buscarDatas(){
		$array = $this->buscarTodasAvaliacoes();
	    $data=array();
	     foreach ($array as $key => $value) {
	        if(array_search($value["data"] ,$data)===FALSE){
	            array_push($data, $value["data"]);
	        } 
	    }
	    	    
	    return $data;
	}

}

 ?>
