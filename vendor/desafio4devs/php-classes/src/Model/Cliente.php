<?php 
namespace Devs\Model;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Cliente{
	private function accessDB(){
		$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/google-service-account.json');

		$firebase = (new Factory)
		    ->withServiceAccount($serviceAccount)
		    ->withDatabaseUri('https://desafio-4-devs-forlogic.firebaseio.com/')
		    ->create();
	    return $firebase;
	}

	public function addCliente($empresa , $contato , $data_cadastro , $status){
		$firebase = $this->accessDB();
		$database = $firebase->getDatabase();
		
		if(!isset($empresa)||!isset($contato)||!isset($data_cadastro)||!isset($status)){
			throw new \Exception("Todas as informações devem estar preenchidas para continuarmos o cadastro!");
		}else{
			$database->getReference('clientes')
		   	->push([
		       'empresa' => $empresa,
		       'nome do contato' => $contato,
		       'data de cadastro' => $data_cadastro,
		       'status'=>$status,
		       'classificação'=>"Nenhum",
		       'chave'=>""
		      ]);
		   	$chave = $this->buscarChaveCliente($empresa);
			$updates = [
			    'clientes/'.$chave.'/chave' => $chave
			];

			$database->getReference()->update($updates);
		}
	}
	
	public function updateCliente($key,$empresa,$contato,$data_cadastro,$status){
		if(!isset($empresa)||!isset($contato)||!isset($data_cadastro)||!isset($status)){
			throw new \Exception("Todas as informações devem estar preenchidas para continuarmos o cadastro!");
		}else{
			$firebase = $this->accessDB();
			$database = $firebase->getDatabase();
			$keyempresa = 'clientes/' . $key . '/empresa';
			$keycontato='clientes/' . $key . '/nome do contato';
			$keycadastro='clientes/' . $key . '/data de cadastro';
			$keystatus='clientes/' . $key . '/status';
			$database->getReference($keyempresa)->set($empresa);
			$database->getReference($keycontato)->set($contato);
			$database->getReference($keycadastro)->set($data_cadastro);
			$database->getReference($keystatus)->set($status);	
		}
	}

	public function deleteCliente($chave){
		$firebase = $this->accessDB();
		$database = $firebase->getDatabase();
		$key = 'clientes/' . $chave;
		$database->getReference($chave)->remove();
	}

	public function buscarTodosClientes(){
		$firebase = $this->accessDB();
		$database = $firebase->getDatabase();
		$results[]=$database->getReference('clientes')->getSnapshot()->getValue();
		return  $results[0];
	}

	public function buscarCliente($chave){
		$firebase = $this->accessDB();
		$database = $firebase->getDatabase();
		$results[]=$database->getReference('clientes')->orderByChild('chave')->equalTo($chave)->getSnapshot()->getValue();
		$args = $results[0];
		foreach($args as $key => $value)
		{
		  return $value;
		} 
	}

	public function buscarChaveCliente($empresa){
		$firebase = $this->accessDB();
		$database = $firebase->getDatabase();
		$results[]=$database->getReference('clientes')->orderByChild('empresa')->equalTo($empresa)->getSnapshot()->getValue();
		$data = $results[0];
		foreach($data as $key => $value)
		{
		  return $key;
		} 
	}
}


 ?>