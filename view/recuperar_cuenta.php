<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sistema K3</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End Plugin css for this page -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="../assets/css/demo_3/style.css">
  <!-- End Layout styles -->
  <link rel="shortcut icon" href="../assets/images/favicon2.png" />
</head>

<body class="dark-theme">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper auth p-0 theme-two">
        <div class="row d-flex align-items-stretch">
          <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
            <div class="slide-content bg-2"> </div>
          </div>
          <div class="col-12 col-md-8 h-100 card">
            <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">

              <form autocomplete="off">
                <div  class="alert alert-success" role="alert" id="mensajeError"></div>
                <div style="padding: 40px;">
                  <h3 class="mr-auto">Actualizar Contraseña</h3>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="mdi mdi-account-outline"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Rut" id="rut" name="rut">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="mdi mdi-account-outline"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Nombre" id="name" name="name">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="mdi mdi-lock-outline"></i>
                      </span>
                    </div>
                    <input type="password" class="form-control" placeholder="Nueva Contraseña" id="newpass"
                      name="newpass">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="mdi mdi-lock-outline"></i>
                      </span>
                    </div>
                    <input type="email" class="form-control" placeholder="correo" id="correo" name="correo">
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary submit-btn" id="cambiar_pass">SIGN IN</button>
                </div>
                <div class="wrapper mt-5 text-gray">
                  <p class="footer-text">Copyright © 2023 Kon3ctados. All rights reserved.</p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../assets/js/shared/off-canvas.js"></script>
  <script src="../assets/js/shared/hoverable-collapse.js"></script>
  <script src="../assets/js/shared/misc.js"></script>
  <script src="../assets/js/shared/settings.js"></script>
  <script src="../assets/js/shared/todolist.js"></script>


  <script>

$(document).ready(function () {
      // Oculta el div de alerta al cargar la página
      $("#mensajeError").hide();

    $("#cambiar_pass").click(function (event) {
      event.preventDefault();

      var usu_rut = $("#rut").val();
      var usu_usu = $("#name").val();
      var newPass = $("#newpass").val();
      var correo = $("#correo").val();

      //validador  #correo
      $.ajax({
        type: "POST", // Método de la solicitud
        url: "../controller/EJECUTIVO/components/recuperar_cuenta.php", // URL del script de manejo de inicio de sesión
        data: {
          usu_rut: usu_rut,
          usu_usu: usu_usu,
          newPass: newPass,
          correo: correo
        },
        success: function (response, status) {
          // Verifica el status de la respuesta
          if (status === "success") {
            // Verifica el contenido de la respuesta
            $("#mensajeError").text(response);
            // Redirige a la página de dashboard u otra página de éxito
            $("#mensajeError").show();

            // Limpia los valores de los inputs
            $("#usu_rut").val('');
            $("#usu_usu").val('');
            $("#newPass").val('');
            $("#correo").val('');
            

            setTimeout(() => {
                window.location.href = 'http://localhost:8000/index.php';
            }, 2000);




          } else {
            // Muestra un mensaje de error en el elemento con id "mensajeError"
            $("#mensajeError").text("Error en la solicitud AJAX");
            $("#mensajeError").show(); // Muestra el div de alerta
          }
        },
        error: function () {
          // Maneja los errores de la solicitud
          $("#mensajeError").text("Error en la solicitud AJAX");
          $("#mensajeError").show(); // Muestra el div de alerta
        }
      });
    })

  })
  </script>

  <!-- endinject -->
  <!-- Custom js for this page -->
  <!-- End custom js for this page -->
</body>

</html>