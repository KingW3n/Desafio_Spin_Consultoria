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
            '<td>R$ '+response+',00</td>'+
            '<td><img id="ImagemLixeira"src="src/39220.png" class="close" onclick="excluirCliente()"></td>'+ 
            '</tr>').appendTo(scntDiv);
          limparCampos();ocultarLoad();
        }
      });
    }else{
      alert('Verifique se todos os campos estão preenchidos corretamente e tente novamente')
    }
  })
  $(".btn_simular").click(function(){
    if(veridicarTr() == "existe"){  
      $.ajax({
        type:'POST',
        url: 'lib/php/controler.php',
        data: "condicao=calcular",
        dataType: 'JSON',
        success: function(response){
          $("#orcamento").show();
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

  function veridicarTr(){
    if($(".tdNome")[0]){
      return "existe";
    }else{
      return "Não existe"
    }
  }

  //Função criada para limpar os campos do projeto.
  function limparCampos(){
    $("input,select").val("");
  } 

  $("#btnVoltar").click(function(){
    $("#orcamento").hide();
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

//Função criada para excluir o cliente ja adicionado
function excluirCliente(){
  exibirLoad();
  $(document).on('click', '.close', function (){
    $(this).parents('tr').remove();
  });
  ocultarLoad();
}

