$(document).ready(function () {
  $("#generarTach").click(function (event) {
    event.preventDefault();

    var fechaInicio = $("#fechaInicio").val();
    var fechaFin = $("#fechaFin").val();

    $.ajax({
      type: "POST",
      url: "../controller/TACH/informes.php",
      data: {
        fechaInicio: fechaInicio,
        fechaFin: fechaFin,
      },
      dataType: "json",
      success: function (response, status) {
        console.log("estoy funcionando en tach");
        console.log(response.data);

        $("#tuContenedor1").load("pages/TACH/components/tabla_audios.php", {
          resultArray: JSON.stringify(response.data),
        });
      },
      async: true,
    });
  });
});
