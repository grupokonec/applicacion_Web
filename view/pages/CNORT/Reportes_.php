<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Costanera Norte</h4>
        <div class="row grid-margin">
          <div class="col-12">
            <div class="alert alert-success" role="alert">
              Informes <strong>Costanera Norte </strong> </div>


            <p class="card-description"> En esta sección, puedes generar informes detallados según tus necesidades.
              Desde informes semanales y diarios hasta visualizar pagos, gestiones y más, tienes la capacidad de obtener
              una visión completa y actualizada de la información clave para tomar decisiones informadas y estratégicas.
            </p>


            <form action="../controller/CNORT/descargar_cnort.php" method="post">

              <p class="card-description">Seleccione el tipo de informe:</p>
              <select id="tipo_informe" name="tipo_informe" class="custom-select" required>
                <option value="">Elige una opción</option>
                <option value="reporte_semanal" hidden>Reporte semanal</option>
                <option value="pagos">Pagos</option>
                <option value="bot" hidden>Bot</option>
                <option value="inbound" hidden>Inbound Historicos</option>
                <option value="cartera_totales">Cartera Totales</option>
                <option value="bloqueados">Bloqueados</option>
                <option value="lista_negra">Lista Negra Telefonico</option>
                <option value="lista_negra_mail">Lista Negra Mail</option>
                <option value="asignados">Asignados</option>
                <option value="recupero">Recupero Ejecutivo</option>
              </select><br><br>
              <input class="btn-save btn btn-primary btn-sm" type="submit" value="Generar">
            </form>



          </div>
        </div>


        <div class="row">
          <div class="col-12">
            <div class="table-responsive">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function showLoadingIndicator() {


    $('#loading-indicator').show();
    $('#no').hide();


    $.ajax({
      type: 'POST',
      url: '../controller/CNORT/descargar_cnort.php',
      data: $('#informeForm').serialize(), // Serializa el formulario
      success: function (data) {

        $('#loading-indicator').hide();

        $('#no').show();

      },
      error: function (error) {
        console.error('Error en la solicitud AJAX:', error);
      }
    });

    return false; // Evita que el formulario se envíe de forma normal
  }
</script>