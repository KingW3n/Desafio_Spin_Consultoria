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
		case 'calcular':
			$aNomes = explode(',', $_POST['nomes']);
		 	$aIdades = explode(',', $_POST['idades']);
		 	$aPlanos = explode(',', $_POST['planos']);
			$classControler = new classControler;
			$valor = $classControler->gerarOrçamento($aNomes,$aIdades,$aPlanos);
			die(json_encode($valor));
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

		public function gerarOrçamento($aNomes,$aIdades,$aPlanos)
		{	
			$consulta = new consulta;
			$retornoplano = $consulta->consultaPlano();
			$retornopreco = $consulta->consultaPreco();
			$aTiposdePlanos = array_unique($aPlanos, SORT_REGULAR);
			$aCodigoPlano = array();
			$aQuantidadeplanos = array();
			$aQuantidadeplanos = array();
			
			//Identifica quantos planos de cada possui 
			foreach ($aTiposdePlanos as $value) {
				$i = 0;
				foreach ($aPlanos as $v) {
					if($v == $value){
						$i++;
					}
				}
				array_push($aQuantidadeplanos, $i);
			}
			//Identifica o codigo dos planos escoçhidos
			foreach ($aTiposdePlanos as $value) {
				foreach ($retornoplano as $v) {
					if($v['nome'] == $value){
					 	array_push($aCodigoPlano, $v['codigo']);
					}
				}
			}
			

			print_r($aQuantidadeplanos);
			print_r($aCodigoPlano);

			foreach ($aCodigoPlano as $valor) {
				
			}

			$html=	'<table>
						<tr>
							<th>Nº</th>
							<th>Nome do Contratante</th>
							<th>Idade</th>
							<th>Nome do Plano</th>
							<th>Valor</th>
						</tr>';


			$html=$html.'</table>';



    
		return $html;	

		}
	}
?>