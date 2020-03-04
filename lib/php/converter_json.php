<?php

class consulta
{
	
	 public function consultaPlano(){
		$aDadosPlano = array();
		if ( is_file ( 'lib/json/planos.json' )){
			$arquivo = file_get_contents("lib/json/planos.json");
		}elseif ( is_file ( '../json/planos.json' )){
			$arquivo = file_get_contents("../json/planos.json");
		}
		$json = json_decode($arquivo);
		foreach ($json as $key => $valor) {
			$aDadosPlano[] = array("registro" => $valor->registro,"codigo" => $valor->codigo,"nome" => $valor->nome);
		}
		return $aDadosPlano;
	}
	public function consultaPreco(){
		$aDadosPreco = array();
		if ( is_file ( 'lib/json/precos.json' )){
			$arquivo = file_get_contents("lib/json/precos.json");
		}elseif ( is_file ( '../json/precos.json' )){
			$arquivo = file_get_contents("../json/precos.json");
		}
		$json = json_decode($arquivo);
		foreach ($json as $key => $valor) {
			$aDadosPreco[] = array("codigo" => $valor->codigo,"minimo_vidas" => $valor->minimo_vidas,"faixa1" => $valor->faixa1, "faixa2"=>$valor->faixa2, "faixa3"=>$valor->faixa3 );
		}
		return $aDadosPreco;
	}
}
	
?>