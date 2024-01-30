$(document).ready(function () {
  $("#generarRhh2").click(function (event) {
    event.preventDefault();
    $("#tuContenedor1").html('<div class="jumping-dots-loader" style="height: 100%; width: inherit;  display: flex; justify-content: center; align-items: center;"><img style="width: 100%; height: 100%;" src="../assets/images/Logof.gif" alt=""></div>');

   

    var fechamonth1 = $("#fechamoth1").val();

    $.ajax({
      url: "../controller/RHH/telefonos.php",
      type: "POST",
      data: {
        fechamonth1: fechamonth1,
      },
      dataType: "json",
      success: function (response, status) {
        console.log(response);
        if (status === "success") {
          try {
            if (response.success) {
              $("#tuContenedor1").load(
                "pages/RHH/components/table_telefonos.php",
                {
                  resultArray: JSON.stringify(response.data),
                }
              );
              $(".jumping-dots-loader").hide();
            } else {
              console.error(
                "Error en la respuesta del servidor:",
                response.error
              );
            }
          } catch (error) {
            console.error("Error al analizar la respuesta JSON:", error);
          }
        }
      },
      async: true,
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("error", textStatus, errorThrown);
      },
    });
  });

  /* -------------------------Segundo Boton ----------------*/

  $("#generarRhh").click(function (event) {
    event.preventDefault();

    $("#tuContenedor").html('<div class="jumping-dots-loader" style="height: 100%; width: inherit;  display: flex; justify-content: center; align-items: center;"><img style="width: 100%; height: 100%;" src="../assets/images/Logof.gif" alt=""></div>');

    var fechamonth = $("#fechamoth").val();
    var buttonsValue = $("input[name='option']:checked").val();

    $.ajax({
      url: "../controller/RHH/Email.php",
      type: "POST",
      data: {
        fechamonth: fechamonth,
        buttonsValue: buttonsValue,
      },
      dataType: "json",
      success: function (response, status) {
        if (status === "success") {
          console.log("La solicitud fue exitosa");

          // Verificar el tipo de respuesta
          if (response.type === "email") {
            // Cargar tabla de email
            $("#tuContenedor").load("pages/RHH/components/tabla_email.php", {
              resultArray: JSON.stringify(response.data),
            });
            $(".jumping-dots-loader").hide();
          } else if (response.type === "sms") {
            // Cargar tabla de SMS
            $("#tuContenedor").load("pages/RHH/components/tabla_sms.php", {
              resultArray: JSON.stringify(response.data),
            });
            $(".jumping-dots-loader").hide();
          } else {
            console.log("Tipo de respuesta no reconocido.");
          }
        }
      },
      async: true,
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("error", textStatus, errorThrown);
      },
    });
  });

  /*-------------------este es para el segundo----------------------*/
});
