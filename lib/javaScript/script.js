function scriptBody(){

//função ultilizada quando clica no adicionar
  $("#btnAdicionarCliente").click(function(){
    if(VerificaCamps() == ""){
      $.ajax({
        type:'POST',
        url: 'lib/php/controler.php',
        data: "condicao=criarCampoDoCliente&nome="+$('#inputNome').val()+"&idade="+$('#inputIdade').val()+"&plano="+$('#inputPlano').val(),
        dataType: 'JSON',
        beforeSend: function(){
          exibirLoad();
        },
        success: function(response){
          var scntDiv = $('#tableCliente');
          $('<tr>'+
            '<td class="tdNome">'+$('#inputNome').val()+'</td>'+
            '<td class="tdIdade">'+$('#inputIdade').val()+'</td>'+
            '<td class="tdPlano">'+$('#inputPlano option:selected').text()+'</td>'+
            '<td>'+response+'</td>'+
            '<td><img id="ImagemLixeira"src="src/39220.png" class="close" onclick="excluirCliente()"></td>'+ 
            '</tr>').appendTo(scntDiv);
            if(veridicarTr()=="existe"){
              $('.itensAdicionados').css({'display':'block'});
            }
          limparCampos();ocultarLoad();
        }
      });
    }else{
      alert('Verifique se todos os campos estão preenchidos corretamente e tente novamente')
    }
  })
  $(".btn_simular").click(function(){
    var aNomes = [];
    var aIdades = [];
    var aPlanos = [];
    $(".tdNome").each(function() {aNomes.push($(this).text())});
    $(".tdIdade").each(function() {aIdades.push($(this).text())});
    $(".tdPlano").each(function() {aPlanos.push($(this).text())});
    if(veridicarTr() == "existe"){  
      $.ajax({
        type:'POST',
        url: 'lib/php/controler.php',
        data: "condicao=calcular&nomes="+aNomes+"&idades="+aIdades+"&planos="+aPlanos,
        dataType: 'JSON',
        success: function(response){
          $("#orcamento").show();
          $("#folha").html(response[0].html);
          $(".lb_campTotal").text(response[0].sum);
        }
      }); 
    }else{
      alert('Você não adicionou clientes, adicione e tente novamente.')
    }
  })

  //Função criada para Verificar se os campos estão preenchidos, caso não esteja deixa sua borda Red
  function VerificaCamps(){
    var val ="";
    if($('#inputNome').val()!=""){
      $("#inputNome").css({"border-color":"#ced4da"});
    }else{
      $("#inputNome").css({"border-color":"red"});
      val = "erro";
    }
     
    if($('#inputIdade').val() != ""){
      $("#inputIdade").css({"border-color":"#ced4da"});
    }else{
      $("#inputIdade").css({"border-color":"red"});
      val = "erro";
    }

    if($('#inputPlano').val()!=""){
      $("#inputPlano").css({"border-color":"#ced4da"});
    }else{
      $("#inputPlano").css({"border-color":"red"});
      val = "erro";
    }
    return val;
  }

  //Função criada para limpar os campos do projeto.
  function limparCampos(){
    $("input,select").val("");
  } 

  $("#btnVoltar").click(function(){
    $("#orcamento").hide();
    $("#folha").html("");
  })
    
  
}

function exibirLoad(){
  $('#LOADINGSAVE').show();
  $("input,select,button").attr('disabled', true);
}

function ocultarLoad(){
  $('#LOADINGSAVE').hide();
  $("input,select,button").attr('disabled', false);
}
function veridicarTr(){
  if($(".tdNome")[0]){
    return "existe";
  }else{
    return "Não existe"
  }
}

//Função criada para excluir o cliente ja adicionado
function excluirCliente(){
  exibirLoad();
  $(document).on('click', '.close', function (){
    $(this).parents('tr').remove();
    if(veridicarTr()!="existe"){
      $('.itensAdicionados').css({'display':'none'});
    }
  });
  ocultarLoad();
}

