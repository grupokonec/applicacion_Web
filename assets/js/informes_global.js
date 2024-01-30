console.log("it worked");

$("#generar_info").click(function (event) {
  event.preventDefault();
  console.log("it worked2");
  var fecha1 = $("#fecha1").val();
  var fecha2 = $("#fecha2").val();

  // Construir una URL con los parámetros
  var url = "../controller/GLOBAL/informe_global.php";
  var params = "fecha1=" + fecha1 + "&fecha2=" + fecha2;

  // Redirigir a la URL
  window.location.href = url + "?" + params;

  console.log("it worked end");
});

