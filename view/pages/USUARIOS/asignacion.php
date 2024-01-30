<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert" id="mensajeError"></div>
                <form autocomplete="off">
                    <div class="form-group">
                        <label for="rut">RUT:</label>
                        <input type="text" class="form-control" id="rut" name="rut" style="color: #000;" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" style="color: #000;" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Correo:</label>
                        <input type="email" class="form-control" id="correo" name="correo" style="color: #000;"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" style="color: #000;"
                            required>
                    </div>

                    <button id="loginButton" class="btn btn-primary">Agregar Usuario</button>
                </form>

            </div>
        </div>
    </div>
</div>






<div class="card">
    <div class="card-body">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px;">
            <h4 class="card-title">PERMISOS</h4>
            <button type="button" class="btn-save btn btn-warning btn-sm" data-toggle="modal"
                data-target="#agregarUsuarioModal">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <?php
        include('../../../config/conexionBD.php');
        include("../../../controller/USUARIOS/controllerAsignacion.php")
            ?>

        <div class="jsgrid-load-shader" style="display: none; position: absolute; inset: 0px; z-index: 1000;"></div>
        <div class="jsgrid-load-panel" style="display: none; position: absolute; top: 50%; left: 50%; z-index: 1000;">
            Please, wait...</div>
    </div>
</div>



<script>
    $("#loginButton").click(function (event) {
        // Previene el comportamiento por defecto del botón de envío del formulario
        event.preventDefault();

        // Oculta el div de alerta al hacer clic en el botón de inicio de sesión
        $("#mensajeError").hide();

        // Obtiene los valores del formulario
        var rut = $("#rut").val();
        var nombre = $("#nombre").val();
        var correo = $("#correo").val();
        var password = $("#password").val();
        // Realiza una solicitud AJAX para enviar los datos del formulario
        $.ajax({
            type: "POST", // Método de la solicitud
            url: "controller/login.php", // URL del script de manejo de inicio de sesión
            data: {
                rut,
                nombre,
                correo,
                password
            },
            success: function (response, status) {
                // Verifica el status de la respuesta
                if (status === "success") {
                    // Verifica el contenido de la respuesta
                    if (response.trim() === "success") {
                        // Redirige a la página de dashboard u otra página de éxito
                        window.location.href = "../../view/dashboard.php";
                    } else {
                        // Muestra un mensaje de error en el elemento con id "mensajeError"
                        $("#mensajeError").text(response);
                        $("#mensajeError").show(); // Muestra el div de alerta
                    }
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
    });
</script>