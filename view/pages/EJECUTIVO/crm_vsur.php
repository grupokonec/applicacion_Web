

<div class="card">
  <div class="card-body">
    <h4 class="card-title">Autopista Vespucio Sur</h4>
    <div class="row">
      <div class="col-12">

        <p class="card-description"> 
          <strong>BUSCAR RUT:</strong>
        </p>

        <form class="form-horizontal" id="searchForm" method="post" autocomplete="off">
          <div class="form-group row">
            <div class="col-sm-4">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Ingrese el RUT" id="rut" name="rut" required>
              </div>
            </div>
          </div>
          <input type="button" value="Buscar" class="btn btn-primary" onclick="buscarCliente()">
        </form>
        <br>

        <div id="resultado">
          <!-- Aquí se mostrarán los resultados -->
        </div>

      </div>
    </div>

  </div>
</div>


<script>
  function buscarCliente() {
    // Obtener los datos del formulario
    var rut = document.getElementById("rut").value;

    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configurar la solicitud
    xhr.open("POST", "../controller/EJECUTIVO/gestion_.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Configurar la función de devolución de llamada cuando la solicitud se complete
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        // Actualizar la sección de resultados con la respuesta del servidor
        document.getElementById("resultado").innerHTML = xhr.responseText;
      }
    };

    // Enviar la solicitud con los datos del formulario
    xhr.send("rut=" + rut);
  }
</script>