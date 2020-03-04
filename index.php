<?php
	require("lib/php/converter_json.php");
	$consulta = new consulta;
	$planos = $consulta->consultaPlano();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Consulta de Planos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="lib/css/mystyle.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" src="lib/javaScript/script.js" charset="utf-8"></script>
</head>
<body onload="scriptBody();">
	<div class="container">
		<h3> Consulta de Planos</h3>
		<fieldset class="border_fild" >
			<legend class="bordear">Adicionar Cliente:</legend>
			<form>
				<div class="row">
    				<div class="col">
    					<label>Nome:</label>
    					<input class="form-control" id="inputNome" type="text" placeholder="Nome">
    				</div>
    			</div>
  				<div class="row">
    				<div class="col">
    					<label>Idade:</label>
      					<input type="text" id="inputIdade" class="form-control" placeholder="Idade">
    				</div>
    				<div class="col">
    					<label>Plano:</label>
      					<select class="form-control Select_planos"  id="inputPlano" placeholder="Plano"> 
      						<option value="">Selecione um Plano</option>
      						<?php 
      						foreach ($planos as $plano) {
      							?><option value="<?php echo $plano['codigo']?>"><?php echo $plano['nome']?></option><?php
      						}
      						?>
      					</select>
    				</div>
  				</div>
  				<br>
  				<center><button type="button" id="btnAdicionarCliente" class="btn btn-primary">Adicionar</button></center>
			</form>
		</fieldset>
		<div class="row">	
        	<div class="itensAdicionados">
        		<table id="tableCliente">
        			<tr>
        				<th>Nome</th>
        				<th>Idade</th>
        				<th>Plano</th>
        				<th>Valor Unitario</th>
        				<th>  </th>
        			</tr>
        		</table>
            </div>       
        </div>
		<center><button type="button" class="btn btn-success btn_simular" >Calcular Orçamento</button></center>
	</div>
  <div id="orcamento">
    <center><a class="btn btn-primary btn-lg active" role="button" id="btnVoltar" aria-pressed="true">Voltar e Editar</a>
    <a href="index.php" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Novo Orçamento</a></center>

  </div>
	<div id="LOADINGSAVE">
		<img src="src/load.gif" width="100%">
	</div>
</body>
<footer>
	<img src="src/logo.png" class="logo_img">
	<p>© Copyright - All Rights Reserved</p>
</footer>
</html>