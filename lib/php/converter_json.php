<?php

class consulta
{
	
	 public function consultaPlano(){
		$aNomesPlano = array();
		$arquivo = file_get_contents("lib/json/planos.json");
		$json = json_decode($arquivo);
		foreach ($json as $key => $valor) {
			$aNomesPlano[] = array("codigo" => $valor->codigo,"nome" => $valor->nome);
		}
		return $aNomesPlano;
	}
}
	
?>