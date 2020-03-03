function scriptBody(){

  $("#btnAdicionarCliente").click(function(){
    if(VerificaCamps() == ""){
      $.ajax({
        type:'POST',
        url: 'lib/php/controler.php',
        data: "condicao=criarCampoDoCliente&nome="+$('#inputNome').val()+"&idade="+$('#inputIdade').val()+"&plano"+$('#inputPlano').val(),
        dataType: 'JSON',
        success: function(response){
          var scntDiv = $('.itensAdicionados');
          $('<div class="clienteadicionado" name="clienteadicionado" id="clienteadicionado">'+
            '<label>oi-oi</label>'+
            '<button type = "button" class = "close" name = "close" value = "oioi" id="BtEmailCose" onclick="ExcluirAcompanhante()" >'+
            '<span>&times;</span>'+
            '</button>'+
            '</div>').appendTo(scntDiv);
          }
      });
    }else{
      alert("Verifique se todos os campos estão preenchidos corretamente e tente novamente")
    }
  })
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
 
}



function pchSession(){
  $.ajax({
    type:'POST',
    url: 'lib/json/planos.json',
    dataType: 'JSON',
    success: function(response){
      $('.Select_planos').find('option').remove();
      for (var i = 0; i < response.length ; i++) {
        if(i== 0){
          $('.Select_planos').append(new Option("SELECIONE O PLANO",""));
        }
        $('.Select_planos').append(new Option(response[i].nome,response[i].codigo));
      }
    }
  });
}