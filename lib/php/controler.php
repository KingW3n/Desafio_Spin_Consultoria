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
			$aValoresPlanoEscolhido = array();
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
			//Identifica o codigo dos planos escolhidos
			foreach ($aTiposdePlanos as $value) {
				foreach ($retornoplano as $v) {
					if($v['nome'] == $value){
					 	$aCodigoPlano[] =array("codigo" =>$v['codigo'],"nome"=>$value);
					}
				}
			}
			//
			foreach ($aCodigoPlano as $valor) {
				foreach ($retornopreco as $v) {
					if($valor['codigo'] == $v['codigo']){
						$aValoresPlanoEscolhido[] = array("codigo"=>$v['codigo'], "minimo_vidas"=>$v['minimo_vidas'], "faixa1"=>$v['faixa1'], "faixa2"=>$v['faixa2'], "faixa3"=>$v['faixa3']);
					}
				}
			}

			$html=	'<table>
						<tr>
							<th>Nº</th>
							<th>Nome do Contratante</th>
							<th>Idade</th>
							<th>Nome do Plano</th>
							<th>Valor</th>
						</tr>';

			//
			$aValoresPlanoEscolhido_des = array_multisort($aValoresPlanoEscolhido, SORT_DESC);
			echo array_count_values(array_column($aValoresPlanoEscolhido_des, 'codigo'))['6'];
			$contador = count($aCodigoPlano);
			for ($i=0; $i < $contador; $i++) { 
				foreach ($aValoresPlanoEscolhido_des as $value) {
					
				}
			}
			print_r();
			



    
		return $html;	

		}
	}
?>