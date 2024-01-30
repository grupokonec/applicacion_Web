<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/estilos_index.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  <link rel="shortcut icon" href="assets/images/favicon2.png" />
  <title>Kon3ctados</title>
</head>

<body>
  <div class="container-form sign-up">
    <div class="welcome-back">
      <div class="message">
        <h2>Bienvenido a K3</h2>
        <p>Si ya tienes una cuenta por favor inicia sesion aqui</p>
        <button class="sign-up-btn">Iniciar Sesion</button>
      </div>
    </div>
    <form class="formulario" autocomplete="off">
      <div class="alert alert-danger" role="alert" id="mensajeError1"></div>
      <h2 class="create-account">Cambiar Contraseña</h2>
      <input type="text" placeholder="Rut" id="usu_rut" name="usu_rut">
      <input type="text" placeholder="Nombre" id="usu_usu" name="usu_usu">
      <input type="email" placeholder="Correo" id="correo" name="correo">
      <input type="button" value="Registrarse" id="crear_cuenta">
    </form>
  </div>
  <div class="container-form sign-in">

    <form class="formulario" autocomplete="off">
      <div class="alert alert-danger" role="alert" id="mensajeError"></div>
      <h2 class="create-account">Iniciar Sesion</h2>
      <input type="text" placeholder="Rut" id="usu_usuario" name="usu_usuario">
      <input type="password" placeholder="Contraseña" id="usu_clave" name="usu_clave">
      <input type="button" value="Iniciar Sesion" id="loginButton">
    </form>
    <div class="welcome-back">
      <div class="message">
        <p>Si olvidaste la consetraña</p>
        <button class="sign-in-btn">Cambiar Contraseña</button>
      </div>
    </div>
  </div>
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="assets/js/shared/off-canvas.js"></script>
  <script src="assets/js/shared/hoverable-collapse.js"></script>
  <script src="assets/js/shared/misc.js"></script>
  <script src="assets/js/shared/settings.js"></script>
  <script src="assets/js/shared/todolist.js"></script>
  <script src="assets/js/shared/todolist.js"></script>
  <script src="assets/js/index.js"></script>
</body>

</html>