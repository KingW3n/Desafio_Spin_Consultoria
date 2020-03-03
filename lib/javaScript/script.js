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