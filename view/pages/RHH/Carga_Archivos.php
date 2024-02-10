<style>
    .carpeta-hover {
        background-color: #f0f0f0;
        /* Color de fondo claro para el hover */
        border: 2px dashed #666;
        /* Borde punteado para indicar la "zona de drop" */
    }

    .archivo-y-descarga {
        display: flex;
        align-items: center;
        /* Alinea los elementos en el eje cruzado (verticalmente) */
        justify-content: flex-start;
        /* Alinea los elementos al inicio (horizontalmente) */
    }

    .archivo {
        list-style-type: none;
        /* Elimina los estilos predeterminados de lista */
    }

    .icono-descarga {
        padding-left: 10px;
        /* Espacio entre el nombre del archivo y el icono de descarga */
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12 col-md-8 h-100 card d-flex flex-column">
            <!-- Formulario para crear nuevo archivo -->
            <div id="estructuraDirectorios"></div>
            <div class="col-12 col-md-8 h-100 card d-flex flex-column">
                <div id="progressBar" style="width: 0%; height: 20px; background-color: green;"></div>
            </div>
        </div>

    </div>
</div>

<script src="../assets/js/loadCarpet.js"></script>