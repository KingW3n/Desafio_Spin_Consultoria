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
			

			$html=	'<table>
						<tr>
							<th>Nº</th>
							<th>Nome do Contratante</th>
							<th>Idade</th>
							<th>Nome do Plano</th>
							<th>Valor</th>
						</tr>';
			//
    		
			$avalorPlanoVerificado = $this->retornarValorPlanos($aCodigoPlano, $retornopreco,$aQuantidadeplanos);
			$retornoTd = $this->retornraTd($aCodigoPlano,$aNomes,$aIdades,$aPlanos,$avalorPlanoVerificado);
			$html = $html.$retornoTd[0]['html']."</table><table><tr><td>Total:</td><td>".$retornoTd[0]['sum']."</td></tr></table>";

    
			return $html;	

		}

		public function retornarValorPlanos($aCodigoPlano,$retornopreco,$aQuantidadeplanos){
			$aValoresPlanoEscolhido = array();
			foreach ($aCodigoPlano as $valor) {
				foreach ($retornopreco as $v) {
					if($valor['codigo'] == $v['codigo']){
						$aValoresPlanoEscolhido[] = array("codigo"=>$v['codigo'], "minimo_vidas"=>$v['minimo_vidas'], "faixa1"=>$v['faixa1'], "faixa2"=>$v['faixa2'], "faixa3"=>$v['faixa3']);
					}
				}
			}
			rsort($aValoresPlanoEscolhido);
			$contador = count($aCodigoPlano);
			for ($i=0; $i <$contador ; $i++) { 
				$aValores = array();
				foreach ($aValoresPlanoEscolhido as $v) {
					if($v['codigo'] == $aCodigoPlano[$i]['codigo'] ){
						$aValores[] = array("codigo"=>$v['codigo'], "minimo_vidas"=>$v['minimo_vidas'], "faixa1"=>$v['faixa1'], "faixa2"=>$v['faixa2'], "faixa3"=>$v['faixa3']);
					}
				}
				$num = count($aValores);
				switch ($num) {
					case '1':
						$valordoPlano[] = array("codigo"=>$aCodigoPlano[$i]['codigo'],"faixa1"=>$aValores[0]['faixa1'], "faixa2"=>$aValores[0]['faixa2'], "faixa3"=>$aValores[0]['faixa3']);
					break;
					case '2':
						if($aQuantidadeplanos[$i] >= $aValores[0]['minimo_vidas']){
							$valordoPlano[] = array("codigo"=>$aCodigoPlano[$i]['codigo'],"faixa1"=>$aValores[0]['faixa1'], "faixa2"=>$aValores[0]['faixa2'], "faixa3"=>$aValores[0]['faixa3']);
						}else{
							$valordoPlano[] = array("codigo"=>$aCodigoPlano[$i]['codigo'],"faixa1"=>$aValores[1]['faixa1'], "faixa2"=>$aValores[1]['faixa2'], "faixa3"=>$aValores[1]['faixa3']);
						}
					break;
					case '3':

						if($aQuantidadeplanos[$i] >= $aValores[0]['minimo_vidas']){
							$valordoPlano[] = array("codigo"=>$aCodigoPlano[$i]['codigo'],"faixa1"=>$aValores[0]['faixa1'], "faixa2"=>$aValores[0]['faixa2'], "faixa3"=>$aValores[0]['faixa3']);
						}elseif($aQuantidadeplanos[$i] >= $aValores[1]['minimo_vidas']){
							$valordoPlano[] = array("codigo"=>$aCodigoPlano[$i]['codigo'],"faixa1"=>$aValores[1]['faixa1'], "faixa2"=>$aValores[1]['faixa2'], "faixa3"=>$aValores[1]['faixa3']);
						}else{
							$valordoPlano[] = array("codigo"=>$aCodigoPlano[$i]['codigo'],"faixa1"=>$aValores[2]['faixa1'], "faixa2"=>$aValores[2]['faixa2'], "faixa3"=>$aValores[2]['faixa3']);
						}
					
					break;
					case '4':
						if($aQuantidadeplanos[$i] >= $aValores[0]['minimo_vidas']){
							$valordoPlano[] = array("codigo"=>$aCodigoPlano[$i]['codigo'],"faixa1"=>$aValores[0]['faixa1'], "faixa2"=>$aValores[0]['faixa2'], "faixa3"=>$aValores[0]['faixa3']);
						}elseif($aQuantidadeplanos[$i] >= $aValores[1]['minimo_vidas']){
							$valordoPlano[] = array("codigo"=>$aCodigoPlano[$i]['codigo'],"faixa1"=>$aValores[1]['faixa1'], "faixa2"=>$aValores[1]['faixa2'], "faixa3"=>$aValores[1]['faixa3']);
						}elseif($aQuantidadeplanos[$i] >= $aValores[2]['minimo_vidas']){
							$valordoPlano[] = array("codigo"=>$aCodigoPlano[$i]['codigo'],"faixa1"=>$aValores[2]['faixa1'], "faixa2"=>$aValores[2]['faixa2'], "faixa3"=>$aValores[2]['faixa3']);
						}else{
							$valordoPlano[] = array("codigo"=>$aCodigoPlano[$i]['codigo'],"faixa1"=>$aValores[3]['faixa1'], "faixa2"=>$aValores[3]['faixa2'], "faixa3"=>$aValores[3]['faixa3']);
						}
						
					break;
				}
			}
			return $valordoPlano;
		}

		public function retornraTd($aCodigoPlano,$aNomes,$aIdades,$aPlanos,$avalorPlanoVerificado){
			$contador = count($aPlanos);
			$html="";
			$sum = 0.00;
			for ($i=0; $i <$contador ; $i++) { 
				foreach ($aCodigoPlano as $value) {
					if($value['nome'] == $aPlanos[$i]){
						foreach ($avalorPlanoVerificado as $v) {
							if($value['codigo'] == $v['codigo']){
								$c = $i+1;
								$html = $html.	"<tr>
												<td>".$c."</td>
												<td>".$aNomes[$i]."</td>
        										<td>".$aIdades[$i]."</td>
        										<td>".$aPlanos[$i]."</td>";
        										
								if($aIdades[$i] <= 17){
									$sum = $sum + $v['faixa1'] ;
									$html = $html."<td> R$: ". $v['faixa1']."</td></tr>";
								}elseif($aIdades[$i] >=18 && $aIdades[$i]<=40){
									$sum = $sum + $v['faixa2'] ;
									$html = $html."<td> R$: ". $v['faixa2']."</td></tr>";
								}elseif($aIdades[$i] >40){
									$sum = $sum + $v['faixa3'] ;
									$html = $html."<td> R$: ". $v['faixa3']."</td></tr>";
								}
							}
						}
					}
				}
			}
			$aRetorno[] = array("html"=> $html, "sum" =>$sum);
			return $aRetorno;
		}
	}
?>