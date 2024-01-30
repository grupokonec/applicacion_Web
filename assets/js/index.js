const $btnSignIn = document.querySelector(".sign-in-btn"),
  $btnSignUp = document.querySelector(".sign-up-btn"),
  $signUp = document.querySelector(".sign-up"),
  $signIn = document.querySelector(".sign-in");

document.addEventListener("click", (e) => {
  if (e.target === $btnSignIn || e.target === $btnSignUp) {
    $signIn.classList.toggle("active");
    $signUp.classList.toggle("active");
  }
});

$(document).ready(function () {
  // Oculta el div de alerta al cargar la página
  $("#mensajeError").hide();

  // Agrega un evento de clic al botón de login
  $("#loginButton").click(function (event) {
    // Previene el comportamiento por defecto del botón de envío del formulario
    event.preventDefault();

    // Oculta el div de alerta al hacer clic en el botón de inicio de sesión
    $("#mensajeError").hide();

    // Obtiene los valores del formulario
    var usu_usuario = $("#usu_usuario").val();
    var usu_clave = $("#usu_clave").val();

    // Realiza una solicitud AJAX para enviar los datos del formulario
    $.ajax({
      type: "POST", // Método de la solicitud
      url: "controller/login.php", // URL del script de manejo de inicio de sesión
      data: {
        usu_usuario: usu_usuario,
        usu_clave: usu_clave,
      },
      success: function (response, status) {
        // Verifica el status de la respuesta
         console.log(response);
        if (response === "success") {
          // Verifica el contenido de la respuesta
          // Redirige a la página de dashboard de usuario con el parámetro "tipo"
          window.location.href = "view/dashboard.php";
        } else {
          // Muestra un mensaje de error en el elemento con id "mensajeError"
          $("#mensajeError").text("Tipo de usuario existe");
          $("#mensajeError").show(); // Muestra el div de alerta
        }
      },
      error: function () {
        // Maneja los errores de la solicitud
        $("#mensajeError").text("Error en la solicitud AJAX");
        $("#mensajeError").show(); // Muestra el div de alerta
      },
    });
  });


  $("#crear_cuenta").click(function (event) {
    event.preventDefault();

    var usu_rut = $("#usu_rut").val();
    var usu_usu = $("#usu_usu").val();
    var correo = $("#correo").val();

    //validador  #correo
    $.ajax({
      type: "POST", // Método de la solicitud
      url: "controller/cambiar_pass.php", // URL del script de manejo de inicio de sesión
      data: {
        usu_rut: usu_rut,
        usu_usu: usu_usu,
        correo: correo,
      },
      success: function (response, status) {
        // Verifica el status de la respuesta
        if (status === "success") {
          // Verifica el contenido de la respuesta
          $("#mensajeError1").text(response);
          // Redirige a la página de dashboard u otra página de éxito
          $("#mensajeError1").show();

          // Limpia los valores de los inputs
          $("#usu_rut").val("");
          $("#usu_usu").val("");
          $("#correo").val("");
        } else {
          // Muestra un mensaje de error en el elemento con id "mensajeError"
          $("#mensajeError1").text("Error en la solicitud AJAX");
          $("#mensajeError1").show(); // Muestra el div de alerta
        }
      },
      error: function () {
        // Maneja los errores de la solicitud
        $("#mensajeError1").text("Error en la solicitud AJAX");
        $("#mensajeError1").show(); // Muestra el div de alerta
      },
    });
  });

  // Agrega eventos para ocultar el div de alerta al escribir en los campos de usuario o contraseña
  //validador para login
  $("#usu_usuario, #usu_clave").on("input", function () {
    $("#mensajeError").hide();
  });

  //validador para registro
  $("#usu_rut, #usu_usu, #usu_pass, #correo").on("input", function () {
    $("#mensajeError1").hide();
  });
});
