<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item nav-category">
      <div class="preview">
        <i class="icon-user"></i>
        <?php echo $usu_usuario; ?>
      </div>
    </li>
    <?php
    if ($usu_usuario === "Administrador") {
      ?>
      <li class="nav-item">
        <a class="nav-link collapsed" data-toggle="collapse" href="#e-commerce" aria-expanded="false"
          aria-controls="e-commerce">
          <i class="menu-icon typcn typcn-book"></i>
          <span class="menu-title" style="font-size:13.5px">Asignacion</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="e-commerce" style="">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link pagina" href="pages/USUARIOS/asignacion.php"> Personal </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../pages/samples/invoice_2.html"> Invoice 2 </a>
            </li>
          </ul>
        </div>
      </li>
      <?php
    }
    ?>
    <?php
    // Definir un array asociativo con los nombres de las empresas y las direcciones correspondientes
    $accionesEmpresas = array(
      'Vespucio Sur' => array('pages/VSUR/Gestiones_.php', 'pages/VSUR/Reportes_.php','pages/VSUR/Informes.php'),
      'Costanera Norte' => array('pages/CNORT/Bloqueo_.php', 'pages/CNORT/Gestiones_.php', 'pages/CNORT/Reportes_.php','pages/CNORT/Informes.php'),
      'Globalvia' => array('pages/GLOBAL/Cuadratura_.php', 'pages/GLOBAL/Gestiones_.php', 'pages/GLOBAL/Bloqueo_.php', 'pages/GLOBAL/Reportes_.php','pages/GLOBAL/informe_global.php'),
      'Vespucio Oriente' => array('pages/AVO/Cuadratura_.php', 'pages/AVO/Gestiones_.php', 'pages/AVO/Bloqueo_.php', 'pages/AVO/Reportes_.php', 'pages/AVO/Informe_Diario.php'),
      'Vespucio Norte' => array('pages/VNORT/Gestiones_.php', 'pages/VNORT/Reportes_.php', 'pages/VNORT/Bloqueo_.php'),
      'ACSA' => array('pages/ACSA/Cuadratura.php', 'pages/ACSA/Gestiones_.php', 
      'pages/ACSA/Bloqueo_.php', 'pages/ACSA/Reportes_.php','pages/ACSA/Informes.php',
      'pages/ACSA/Mejor_Gestion.php'),
      'TACH' => array('pages/TACH/Audios_.php','pages/TACH/informes.php'),
      'MONITOREO' => array('../fstp/conexion.php', 'bloqueo_vsur.php'),
      'CRM' => array('pages/CRM/CRM_.php', 'pages/VICI/VICIDIAL_.php'),
      'INFORMES' => array(
        'pages/ACSA/components/graficos_ACSA.php',
        'pages/CNORT/components/grafico_CNORT.php',
        'pages/AVO/components/grafico_AVO.php',
        'pages/VSUR/components/grafico_VSUR.php',
        'pages/VNORT/components/grafico_VNORT.php',
        'pages/GLOBAL/components/grafico_GLOBAL.php',
        'pages/prueba_.php',
      ),
      'TICKET' => array('pages/CRM/CRM_.php', 'pages/VICI/VICIDIAL_.php','pages/TICKET/ticket.php'),
      'MAILING' => array('pages/EJECUTIVO/crm_vsur.php'),
      'EJECUTIVOS' => array('pages/EJECUTIVO/Crear_Ejecutivo.php'),
      'RHH' => array('pages/RHH/Email_.php','pages/RHH/Telefonos.php','pages/RHH/Carga_Archivos.php'),
      'HONORARIOS' => array('pages/ACSA/Honorarios.php')
      // Agrega más empresas según sea necesario
    );

    while ($row = $result1->fetch(PDO::FETCH_ASSOC)) {
      // Verificar si el nombre de la empresa existe en el array de acciones
    

      if (isset($accionesEmpresas[$row['nombreEmpresas']])) {
        
        $id = 'ui-' . str_replace(' ', '-', strtolower($row['nombreEmpresas'])); // Crear un id único
    
        echo '<li class="nav-item" data-id="' . $id . '">';
        echo '<a class="nav-link" data-toggle="collapse" href="#' . $id . '" aria-expanded="false" aria-controls="' . $id . '">';
        echo '<i class="menu-icon typcn typcn-coffee"></i>';
        echo '<span class="menu-title">' . $row['nombreEmpresas'] . '</span>';
        echo '<i class="menu-arrow"></i>';
        echo '</a>';
        echo '<div class="collapse" id="' . $id . '">';
        echo '<ul class="nav flex-column sub-menu">';

        // Recorrer las acciones de la empresa actual y generar los enlaces correspondientes
        foreach ($accionesEmpresas[$row['nombreEmpresas']] as $accion) {
          echo '<li class="nav-item">';
          echo '<a class="nav-link pagina"    href="' . $accion . '">' . ucfirst(str_replace('_', ' ', basename($accion, '.php' ))) . '</a>';
          echo '</li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '</li>';
      }
    }
    ?>
  </ul>
</nav>