<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['name'])) {
    header("Location: ../index.php");
    exit();
}




// Acceder a la variable $usu_usuario almacenada en la sesión
$usu_usuario = $_SESSION['name'];
$prove  = $_SESSION['prove'];

// Verificar si 'Gloval vespucion norte' está presente en el arreglo
$showGlobalviaMenu = in_array('global', $prove);
$showVespucioOriente = in_array('vespucio oriente',$prove);
$showCostaneraNorte = in_array('cnort',$prove);
$showVespuciosur = in_array('vsur',$prove);
$showVespucinorte = in_array('vnort',$prove);
$showAutopase = in_array('autop',$prove);
$showMonitoreo = in_array('monitoreo ',$prove);
$showAcsa = in_array('acsa',$prove);
$showAvo = in_array('avo',$prove);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema K3</title>
    <!-- plugins:css -->
   


    <link rel="stylesheet" href="../assets/css/estilos.css">
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End Plugin css for this page -->
    <!-- Plugin css for this page -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/demo_3/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="../assets/images/favicon.png" />
   <style>
    .jumping-dots-loader {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 450px; /* Ajusta la altura según sea necesario */
  }

  .jumping-dots-loader span {
    display: inline-block;
    width: 40px; /* Ajusta el tamaño de cada círculo según sea necesario */
    height: 40px; /* Ajusta el tamaño de cada círculo según sea necesario */
    border-radius: 50%;
    margin: 0 5px; /* Ajusta el espacio entre los círculos según sea necesario */
  }

   </style>
  </head>
  <body class="dark-theme">
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="index.php">
            <img src="../assets/images/faces/LOGOK3.png" alt="logo" /> </a>
          <a class="navbar-brand brand-logo-mini" href="index.php">
            <img src="../assets/images/faces/LOGOK3.png" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown" hidden >
              <a class="nav-link count-indicator" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-bell-outline"></i>
                <span class="count">7</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
                <a class="dropdown-item py-3">
                  <p class="mb-0 font-weight-medium float-left">You have 7 unread mails </p>
                  <span class="badge badge-pill badge-primary float-right">View all</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="../assets/images/faces/face10.jpg" alt="image" class="img-sm profile-pic"> </div>
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis font-weight-medium">Marian Garner </p>
                    <p class="font-weight-light small-text"> The meeting is cancelled </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="../assets/images/faces/face12.jpg" alt="image" class="img-sm profile-pic"> </div>
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis font-weight-medium">David Grey </p>
                    <p class="font-weight-light small-text"> The meeting is cancelled </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="../assets/images/faces/face1.jpg" alt="image" class="img-sm profile-pic"> </div>
                  <div class="preview-item-content flex-grow py-2">
                    <p class="preview-subject ellipsis font-weight-medium">Travis Jenkins </p>
                    <p class="font-weight-light small-text"> The meeting is cancelled </p>
                  </div>
                </a>
              </div>
            </li>
            
            <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="../assets/images/faces/LOGOK3.png" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="../assets/images/faces/LOGOK3.png" alt="Profile image">
                  <p class="mb-1 mt-3 font-weight-semibold">KON3CTADOS</p>
                  
              </div>
                <button class="dropdown-item" id="closeButton"><i class="dropdown-item-icon mdi mdi-power text-primary"></i>Sign Out</button>
              </div>
            </li>

            
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_settings-panel.html -->

        <!-- partial -->
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            
          <li class="nav-item nav-category">
              <div class="preview">
                        <i class="icon-user"></i><?php echo $usu_usuario;?> 
              </div>
          </li>

            <?php if ($showGlobalviaMenu) : ?>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#dashboard-dropdown" aria-expanded="false" aria-controls="dashboard-dropdown">
                <i class="menu-icon typcn typcn-document-text"></i>
                <span class="menu-title">Globalvia</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="dashboard-dropdown">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link pagina" href="cuadratura_global.php">Cuadratura</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link pagina" href="bloqueo_global.php">Bloqueos</a>
                  </li>                 
                </ul>
              </div>
            </li>
            <?php endif; ?>

            <?php if ($showAutopase) : ?>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
                <i class="menu-icon typcn typcn-archive"></i>
                <span class="menu-title">Autopase</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="page-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link pagina" href="cuadratura_acsa.php">Cuadratura</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link pagina" href="bloqueo_acsa.php">Bloqueos</a>
                  </li>
                </ul>
              </div>
            </li>
            <?php endif; ?>
            <?php if ($showVespucioOriente) : ?>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#apps-dropdown" aria-expanded="false" aria-controls="apps-dropdown">
                <i class="menu-icon typcn typcn-arrow-maximise"></i>
                <span class="menu-title">Vespucio Oriente</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="apps-dropdown">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link pagina" href="cuadratura_avo.php">Cuadratura</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link pagina" href="bloqueo_avo.php">Bloqueos</a>
                  </li>
              
                </ul>
              </div>
            </li>
            <?php endif; ?>

            <?php if ($showCostaneraNorte) : ?>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#sidebar-layouts" aria-expanded="false" aria-controls="sidebar-layouts">
                <i class="menu-icon typcn typcn-calendar-outline"></i>
                <span class="menu-title">Costanera Norte</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="sidebar-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link pagina" href="cuadratura_cnorte.php">Cuadratura</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link pagina" href="bloqueo_cnort.php">Bloqueos</a>
                  </li>
                </ul>
              </div>
            </li>
            <?php endif; ?>

            <?php if ($showVespuciosur) : ?>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon typcn typcn-coffee"></i>
                <span class="menu-title">Vespucio Sur</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link pagina" href="cuadratura_vsur.php">Cuadratura</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link pagina" href="bloqueo_vsur.php">Bloqueos</a>
                  </li>
                </ul>
              </div>
            </li>

            <?php endif; ?>

            <?php if ($showVespucinorte) : ?>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-advanced" aria-expanded="false" aria-controls="ui-advanced">
                <i class="menu-icon typcn typcn-camera-outline"></i>
                <span class="menu-title">Vespucio Norte</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-advanced">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link pagina" href="cuadratura_vnort.php">Cuadratura</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link pagina" href="bloqueo_vnort.php">Bloqueos</a>
                  </li>
                  
                </ul>
              </div>
            </li>
            <?php endif; ?>

           
            <?php if ($showAcsa) : ?>
            <li class="nav-item" >
              <a class="nav-link" data-toggle="collapse" href="#editors" aria-expanded="false" aria-controls="editors">
                <i class="menu-icon typcn typcn-bookmark"></i>
                <span class="menu-title">ACSA</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="editors">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" style=" heigh:50px" href="../../pages/forms/text_editor.html">Text editors</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../../pages/forms/code_editor.html">Code editors</a>
                  </li>
                </ul>
              </div>
            </li>
            <?php endif; ?>

            <?php if ($showAvo) : ?>
            <li class="nav-item" >
              <a class="nav-link" data-toggle="collapse" href="#editors" aria-expanded="false" aria-controls="editors">
                <i class="menu-icon typcn typcn-bookmark"></i>
                <span class="menu-title">AVO</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="editors">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" style=" heigh:50px" href="../../pages/forms/text_editor.html">Text editors</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../../pages/forms/code_editor.html">Code editors</a>
                  </li>
                </ul>
              </div>
            </li>
            <?php endif; ?>

            <?php if ($showMonitoreo) : ?>
              <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
                <i class="menu-icon typcn typcn-archive"></i>
                <span class="menu-title">Monitoreo</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="page-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link pagina" href="../fstp/conexion.php">CNORT VSUR</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link pagina" href="bloqueo_acsa.php">Bloqueos</a>
                  </li>
                </ul>
              </div>
            </li>
            <?php endif; ?>
            
            
          </ul>
        </nav>

        <!-- partial -->

      <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Sistema</h4>
                    <div class="row grid-margin">
                      <div class="col-12" id="contenido">
                        
                        <div class="alert alert-success"   role="alert">
                          Sistema Web para la empresa <strong>Kon3ctados</strong>
                        </div>
                          <img class="img-l"  src="../assets/images/faces/LOGOK3.png" alt="Logok3">
                          
                      </div>
                    </div>  
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
            <div class="container-fluid clearfix">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2023 <a href="#" target="_blank">KON3CTADOS</a>. All rights reserved.</span>
              
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
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
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
    
   
    <script>
    $(document).ready(function() {

        // Manejar clic en enlaces
        $('.pagina').on('click', function(e) {
            e.preventDefault(); // Evitar comportamiento predeterminado de la etiqueta 'a'

            // Obtener la URL del enlace
            var paginaURL = $(this).attr('href');

            // Mostrar el indicador de carga y ocultar el contenido existente
            $('#contenido').html('<div class="jumping-dots-loader"><img src="../img/hola-unscreen.gif" alt=""></div>');

            // Almacenar la última página en localStorage
            localStorage.setItem('ultimaPagina', paginaURL);      

            // Cargar contenido PHP en el elemento 'main'
            $('#contenido').load(paginaURL, function() {
                // Ocultar el indicador de carga después de que se haya cargado el contenido
                $('.jumping-dots-loader').hide();
            });
        });

        // Verificar si hay una última página almacenada en localStorage al cargar la página
        var ultimaPagina = localStorage.getItem('ultimaPagina');


        if (ultimaPagina) {
            // Mostrar el indicador de carga y ocultar el contenido existente
            $('#contenido').html('<div class="jumping-dots-loader"><img src="../img/hola.gif" alt=""></div>');

            // Cargar la última página almacenada en localStorage
            $('#contenido').load(ultimaPagina, function() {
                // Ocultar el indicador de carga después de que se haya cargado el contenido
                $('.jumping-dots-loader').hide();
            });
        }

    });


    document.getElementById('closeButton').addEventListener('click', function() {
      // Enviar una solicitud al servidor para cerrar la sesión
      var xhr = new XMLHttpRequest();
      xhr.open('GET', '../config/cerrar_sesion.php?close=1', true);
      xhr.send();
      
      // Redirigir al usuario a la página principal después de cerrar la sesión
      window.location.href = '../index.php';
    });
</script>

  </body>
</html>

