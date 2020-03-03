<?php
	
	require("converter_json.php");

	$condicaoSwitch = $_POST["condicao"];	

	switch ($condicaoSwitch) {
		case 'criarCampoDoCliente':
			$nome = $_POST["nome"];
			$idade = $_POST["idade"];
			$plano = $_POST["plano"];
			$classControler = new classControler;
			$divCriada = $classControler->criarPHPCliente($nome,$idade,$plano);
			die(json_encode($divCriada)) ;
		break;  
		case 'PuchLogar':
		break;  
		case 'PuchUnidade':
		break;  
		case 'PuchUSerEditSE':
		break; 
	}

	class classControler
	{
		public function criarPHPCliente($nome, $idade,$plano)
		{	
			$consulta = new consulta;
			if($idade >= 17){

			}elseif($idade < 17 and $idade >= 40){

			}elseif($idade < 40){

			}
			$div = "";

			return $div;

		}
	}
?>