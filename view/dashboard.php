<?php

include('../controller/USUARIOS/controllerSearchUser.php');
// Verificar si el usuario ha iniciado sesión


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sistema K3</title>
  <!-- plugins:css -->

  <!--start -->
  <link rel="stylesheet" href="../assets/vendors/simplemde/simplemde.min.css">
  <link rel="stylesheet" href="../assets/vendors/quill/quill.snow.css">
  <link rel="stylesheet" href="../assets/vendors/simplemde/simplemde.min.css">
  <link rel="stylesheet" href="../assets/css/demo_3/style.css">

  <!--end  -->
  <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../assets/vendors/jsgrid/jsgrid.min.css">
  <link rel="stylesheet" href="../assets/vendors/jsgrid/jsgrid-theme.min.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End Plugin css for this page -->
  <!-- Plugin css for this page -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="../assets/css/demo_3/style.css">
  <!-- End Layout styles -->
  <link rel="shortcut icon" href="../assets/images/favicon2.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<!-- Modal for Agregar Usuario -->

<body class=" dark-theme">
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="dashboard.php">
          <img src="../assets/images/Kon3ctados Ajustado.png" alt="logo" /> </a>
        <a class="navbar-brand brand-logo-mini" href="dashboard.php">
          <img src="../assets/images/favicon2.png" alt="logo" /> </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown" hidden>
            <a class="nav-link count-indicator" id="messageDropdown" href="#" data-toggle="dropdown"
              aria-expanded="false">
              <i class="mdi mdi-bell-outline"></i>
              <span class="count">7</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
              aria-labelledby="messageDropdown">
              <a class="dropdown-item py-3">
                <p class="mb-0 font-weight-medium float-left">You have 7 unread mails </p>
                <span class="badge badge-pill badge-primary float-right">View all</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="../assets/images/faces/face10.jpg" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis font-weight-medium">Marian Garner </p>
                  <p class="font-weight-light small-text"> The meeting is cancelled </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="../assets/images/faces/face12.jpg" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis font-weight-medium">David Grey </p>
                  <p class="font-weight-light small-text"> The meeting is cancelled </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <img src="../assets/images/faces/face1.jpg" alt="image" class="img-sm profile-pic">
                </div>
                <div class="preview-item-content flex-grow py-2">
                  <p class="preview-subject ellipsis font-weight-medium">Travis Jenkins </p>
                  <p class="font-weight-light small-text"> The meeting is cancelled </p>
                </div>
              </a>
            </div>
          </li>

          <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <img class="img-xs rounded" src="../assets/images/favicon2.png" alt="Profile image"> </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <div class="dropdown-header text-center">
                <img class="img-md rounded" src="../assets/images/favicon2.png" alt="Profile image">
                <p class="mb-1 mt-3 font-weight-semibold">KON3CTADOS</p>

              </div>
              <button class="dropdown-item" id="closeButton"><i
                  class="dropdown-item-icon mdi mdi-power text-primary"></i>Sign Out</button>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_settings-panel.html -->
      <!-- partial -->
      <!-- Navbar -->
      <?php
      include('./components/navBar.php')
        ?>
      <!-- partial -->


      <div class="main-panel">
        <div class="content-wrapper" id="contenido">
          <div class="d-flex align-items-center justify-content-center flex-column" style="width: 100%; height: 100%;">
            <img class="img-l" src="../assets/images/Kon3ctados Ajustado.png" alt="Logok3">
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2023 <a
                href="http://www.kon3ctados.cl/" target="_blank">Kon3ctados</a>. All rights reserved V.1.2.0</span>

          </div>
        </footer>
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->

  <!-- End custom js for this page -->

  
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
  <script src="../assets/js/shared/todolist.js"></script>
  <script src="../assets/js/ejecuitvos.js"></script>
  <!-- endinject -->

  <script src="../assets/js/dashboard.js"></script>

 
  
</body>

</html>