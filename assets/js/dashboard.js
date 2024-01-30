//revisar
$(document).ready(function () {
  //esto para cargar los powerbi en en cada cartera
  // end
  $(".nav-item").dblclick(function () {
    // Obtiene el valor del atributo data-id
    var id = $(this).data("id");

    // Definir un objeto que mapea los valores de 'id' a las rutas de los archivos PHP
    // Definir un objeto que mapea los valores de 'id' a las rutas de los archivos PHP
    var archivosPHP = {
      "ui-acsa": "pages/ACSA/components/graficos_ACSA.php",
      "ui-costanera-norte": "pages/CNORT/components/grafico_CNORT.php",
      "ui-vespucio-norte": "pages/VNORT/components/grafico_VNORT.php",
      "ui-vespucio-oriente": "pages/AVO/components/grafico_AVO.php",
      "ui-vespucio-sur": "pages/VSUR/components/grafico_VSUR.php",
      "ui-globalvia": "pages/GLOBAL/components/grafico_GLOBAL.php",
      // Agrega más mapeos según sea necesario
    };

    $("#contenido").load(archivosPHP[id], function (response, status, xhr) {
      if (status === "error") {
        // Manejar errores si es necesario
        console.log("Error al cargar el contenido.");
      }
    });
  });

  // fin

  // Manejar clic en enlaces solo para mostrar las paginas dentro del dashboard
  $(".pagina").on("click", function (e) {
    e.preventDefault(); // Evitar comportamiento predeterminado de la etiqueta 'a'

    // Obtener la URL del enlace
    var paginaURL = $(this).attr("href");

    // Mostrar el indicador de carga y ocultar el contenido existente
    $("#contenido").html(
      '<div class="jumping-dots-loader" style="height: 100%; display: flex; justify-content: center; align-items: center;"><img style="height: 400px;" src="../assets/images/Logof.gif" alt=""></div>'
    );

    // Almacenar la última página y el ID de sesión en localStorage
    localStorage.setItem("ultimaPagina", paginaURL);
    localStorage.setItem("sessionID", "<?php echo session_id(); ?>");

    // Cargar contenido PHP en el elemento 'main'
    $("#contenido").load(paginaURL, function () {
      // Ocultar el indicador de carga después de que se haya cargado el contenido
      $(".jumping-dots-loader").hide();
    });
  });

  //end

  // Verificar si hay una última página almacenada en localStorage al cargar la página
  var ultimaPagina = localStorage.getItem("ultimaPagina");
  var sessionID = localStorage.getItem("sessionID");

  if (ultimaPagina && sessionID === "<?php echo session_id(); ?>") {
    // Mostrar el indicador de carga y ocultar el contenido existente
    $("#contenido").html(
      '<div class="jumping-dots-loader" style="height: 100%; display: flex; justify-content: center; align-items: center;"><img style="height: 400px;" src="../assets/images/Logof.gif" alt=""></div>'
    );

    // Cargar la última página almacenada en localStorage
    $("#contenido").load(ultimaPagina, function () {
      // Ocultar el indicador de carga después de que se haya cargado el contenido
      $(".jumping-dots-loader").hide();
    });
  }

  document.getElementById("closeButton").addEventListener("click", function () {
    // Enviar una solicitud al servidor para cerrar la sesión
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../config/cerrar_sesion.php?close=1", true);
    xhr.send();

    // Limpiar las variables de localStorage
    localStorage.removeItem("ultimaPagina");
    localStorage.removeItem("sessionID");

    // Redirigir al usuario a la página principal después de cerrar la sesión
    window.location.href = "../index.php";
  });
});
