<?php
	
	require("converter_json.php");

	$condicaoSwitch = $_POST["condicao"];	

	switch ($condicaoSwitch) {
		case 'criarCampoDoCliente':
			$nome = $_POST["nome"];
			$idade = $_POST["idade"];
			$plano = $_POST["plano"];
			$classControler = new classControler;
			$valor = $classControler->RetornarvalorUnitario($idade,$plano);
			die(json_encode($valor)) ;
		break;  
		
	}

	class classControler
	{
		public function RetornarvalorUnitario($idade,$plano)
		{	
			$consulta = new consulta;
			foreach ($consulta->consultaPreco() as  $valor) {
				if($plano == $valor['codigo'] and $valor['minimo_vidas'] == 1){
					if($idade <= 17){
						$preco =$valor['faixa1'] ;
					}elseif($idade >=18 && $idade<=40){
						$preco =$valor['faixa2'] ;
					}elseif($idade >40){
						$preco =$valor['faixa3'] ;
					}else{
						$preco = "erro";
					}
				}
			}
			return $preco;

		}
	}
?>