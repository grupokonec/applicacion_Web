<div class="jumping-dots-loader" style="height: 100%; display: flex; justify-content: center; align-items: center;"><img
        style="height: 400px;" src="../assets/images/Logof.gif" alt="">
</div>

<div id="confirmationModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Recordar que la fecha debe ser del día anterior, ¿desea continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="continueGeneration()">Sí</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"
                    onclick="cancelGeneration()">No</button>
            </div>
        </div>
    </div>
</div>

<div class="card" style="height:400px" id="no">
    <div class="card-body">
        <div class="row">
            <h3>Generar Informe Diario</h3>
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <p class="card-description">
                        En esta sección, puede generar Informes diarios de una fecha o según rangos de fechas
                    </p>
                </div>
                <form method="post" action="../controller/Reportes/prueba_one.php"
                    style="height:inherit; height: 120px;">

                    <div style="display: flex; justify-content: space-between; width:500px; height:inherit">
                        <div class="form-group">
                            <div>
                                <label for="fecha">Fecha Inicio</label>
                            </div>
                            <input type="date" class="form-control bg-success text-white datepicker" id="fechaInicio"
                                name="fechaInicio" style="font-size: 18px; border-radius: 10px;">
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="fecha">Fecha Fin</label>
                            </div>

                            <input type="date" class="form-control bg-success text-white datepicker" id="fechaFin"
                                name="fechaFin" style="font-size: 18px; border-radius: 10px;">
                        </div>

                    </div>
                    <div style="width:500px" id="errorContainer" class="d-none">
                        <p id="error" class="alert alert-danger"></p>
                    </div>
                    <div class="form-group">

                        <input class="btn btn-info btn-fw btn-save btn btn-primary btn-sm" id="GESTION" type="button"
                            value="Generar" data-toggle="modal" data-target="#confirmationModal"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Resto del HTML ... -->

<script>
    var fechaInicioInput = document.getElementById('fechaInicio');
    var fechaFinInput = document.getElementById('fechaFin');

    fechaInicioInput.addEventListener('input', function () {
        //oculta el error 
        $('#errorContainer').addClass('d-none');

        // Configura la fecha mínima para la fecha de inicio
        fechaFinInput.min = this.value;

        // Configura la fecha máxima para cinco días desde la fecha de inicio
        let fechaInicio = new Date(this.value);
        let fechaFin = new Date(fechaInicio);
        fechaFin.setDate(fechaFin.getDate() + 4);
        fechaFinInput.max = fechaFin.toISOString().split('T')[0];
    });


    fechaFinInput.addEventListener('input', function () {
        // Oculta el error 
        $('#errorContainer').addClass('d-none');
    });

    fechaInicioInput.addEventListener('change', function () {

        // Restablece el valor de la fecha de fin cuando cambia la fecha de inicio
        fechaFinInput.value = '';
    });

    function continueGeneration() {
        // Obtener las fechas
        var fechaInicio = $('#fechaInicio').val();
        var fechaFin = $('#fechaFin').val();

        // Mostrar mensaje de error si alguna de las fechas está vacía
        if (fechaInicio === "" || fechaFin === "") {
            // Ocultar la alerta de confirmación
            $('#confirmationModal').modal('hide');

            // Mostrar el mensaje de error y hacer visible el contenedor
            $('#errorContainer').removeClass('d-none');
            document.getElementById('error').innerText = 'Por favor, complete ambas fechas.';

            return; // Detener la ejecución si las fechas están vacías
        }

        // Limpiar el mensaje de error y ocultar el contenedor
        document.getElementById('error').innerText = '';
        $('#errorContainer').addClass('d-none');

        // Ocultar la alerta de confirmación
        $('#confirmationModal').modal('hide');

        // Mostrar el indicador de carga antes de la descarga

        // Mostrar el indicador de carga antes de la descarga
        $('.jumping-dots-loader').show();
        $('#no').hide();

        // Realizar la descarga a través de un enlace temporal
        var downloadLink = document.createElement('a');
        downloadLink.href = '../controller/Reportes/prueba_one.php?fechaInicio=' + fechaInicio + '&fechaFin=' + fechaFin;


        var partesFecha = fechaFin.split('-');

        // Reorganiza las partes de la fecha en el formato deseado "14122023"
        var fechaFormateada = partesFecha[2] + partesFecha[1] + partesFecha[0];

        downloadLink.download = 'GestionesDiarias' + fechaFormateada + 'Konectados.csv'




        // Usar eventos de la solicitud AJAX
        $.ajax({
            type: 'GET',
            url: downloadLink.href,  // Usar la misma URL que el enlace temporal
            xhrFields: {
                responseType: 'blob'  // Configurar el tipo de respuesta como blob (archivo binario)
            },
            success: function (data) {
                // Se ejecuta cuando la descarga ha finalizado con éxito
             
                // Crear un objeto de URL para el blob
                var blobUrl = URL.createObjectURL(data);

                // Asignar la URL al enlace temporal
                downloadLink.href = blobUrl;

                // Simular un clic en el enlace para iniciar la descarga
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);

                // Ocultar el indicador de carga después de la descarga
                $('.jumping-dots-loader').hide();
                $('#no').show();

                // Liberar el objeto de URL
                URL.revokeObjectURL(blobUrl);
                fechaInicioInput.value = ' ';
                fechaFinInput.value = ' ';
            },
            error: function () {
                // Se ejecuta si hay un error en la descarga

                // Ocultar el indicador de carga en caso de error
                $('.jumping-dots-loaderr').hide();
            }
        });

    }

    function cancelGeneration() {

        // Ocultar la alerta de error
        $('#error').modal('hide');

    }

    function cancelGeneration() {
        $('#confirmation-alert').hide();
        fechaInicioInput.value = ' ';
        fechaFinInput.value = ' ';
    }
</script>