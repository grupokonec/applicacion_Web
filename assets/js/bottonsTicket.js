$(document).ready(function () {
  console.log("por aqui los botones");
 

  $("#show_ticket").hide();
  //para depegar creacion del tickete
  $("#create_ticket").click(function () {
    $("#show_ticket").toggle(1000);
  });

 

  //mostar fecha dentro del div 
  var hoy = new Date();

  // Opciones para formatear la fecha
  var opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

  // Formatear la fecha en español
  var fechaFormateada = hoy.toLocaleDateString('es-ES', opciones);

  document.getElementById("date_ticket").textContent= fechaFormateada
  document.getElementById("date_ticket1").textContent= fechaFormateada
  document.getElementById("date_ticket2").textContent= fechaFormateada

});
