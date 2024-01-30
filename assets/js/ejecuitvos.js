$(document).ready(function() {

    
    $('#tuContenedor').load('pages/EJECUTIVO/components/ejecutivos.php?superv='+$("#super").val());
    
    // Ocultar el mensaje de error
    $("#mensajeError").hide();


$("#btn_ejecutivo").click(function (event) {
    event.preventDefault();

    var usu_rut = $("#usu_rut").val();
    var usu_usu = $("#usu_usu").val();
    var usu_pass = $("#usu_pass").val();
    var correo = $("#correo").val();
    var superv = $("#super").val();
    
    $.ajax({
        type: 'POST',
        url: '../controller/EJECUTIVO/usu_ejecutivo.php',
        data: {
            usu_rut: usu_rut,
            usu_usu: usu_usu,
            usu_pass: usu_pass,
            correo: correo,
            superv: superv  // Agrega la variable $valida
        },
        success: function (response, status) {
            if (status =="success") {
                $("#mensajeError").text(response);
                $("#mensajeError").show();

                   // Limpia los valores de los inputs
                   $("#usu_rut").val('');
                   $("#usu_usu").val('');
                   $("#usu_pass").val('');
                   $("#correo").val('');

                $('#tuContenedor').load('pages/EJECUTIVO/components/ejecutivos.php?superv='+superv);

                setTimeout(()=>{
                    $("#mensajeError").hide();
                }, 2000);
               
            }
        },
        error: function (error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
});
});