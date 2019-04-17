
  $( "#uvjet" ).autocomplete({
    source: putanja + "polaznik/traziPolaznik",
    minLength: 1,
    focus: function(event,ui){
      event.preventDefault();
    },
    select:function(event,ui){
      spremi(ui.item);
    }
  }).data("ui-autocomplete")._renderItem=function(ul,objekt){
      return $("<li><img style=\"max-width: 60px\" src=\"https://randomuser.me/portraits/men/2.jpg\" />" + objekt.ime + " " + objekt.prezime + "</li>").appendTo(ul);
  };

  function spremi(polaznik){

    $.ajax({
      type: "POST",
      url: putanja + "grupa/dodajPolaznika",
      data: "grupa=" + sifraGrupa +"&polaznik=" + polaznik.sifra,
      success: function(vratioServer){
        if(vratioServer==="OK"){
          $("#podaci").append(
            "<tr>" + 
              "<td>" + polaznik.ime + " " + polaznik.prezime + "</td>" +
              "<td><a class=\"obrisi\" id=\"p_" + polaznik.sifra + "\" href=\"#\">Obriši</a></td>" +
           "</tr>");
           definirajBrisanje();
        }else{
          alert(vratioServer);
        }
      }
    });

  }

  function definirajBrisanje(){
    $(".obrisi").click(function(){
      //console.log($(this).attr("id"));
      //let id = $(this).attr("id");
      //let sifraPolaznika = id.split("_")[1];
      //console.log(sifraPolaznika);
      let a = $(this);
      $.ajax({
        type: "POST",
        url: putanja + "grupa/obrisiPolaznika",
        data: "grupa=" + sifraGrupa +"&polaznik=" + a.attr("id").split("_")[1],
        success: function(vratioServer){
          if(vratioServer==="OK"){
           a.parent().parent().remove();
          }else{
            alert(vratioServer);
          }
        }
      });
  
  
    });  
  }
  definirajBrisanje();

  














