<?php
session_start();

$name = $_SESSION['name'];
$email = $_SESSION['Correo'];
$rut = $_SESSION['usu_id'];
$idgrupo = $_SESSION['idgrupo'];
$rol = $_SESSION['idroles'];
?>

<link rel="stylesheet" href="../assets/vendors/jquery-toast-plugin/jquery.toast.min.css">
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex pb-4 mb-4 border-bottom">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title mb-n2">Tickets</h5>
                        <p  class="mt-2 mb-n1 ml-3 text-muted" ></p>
                    </div>
                    <div class="ml-auto d-flex align-items-stretch w-50 justify-content-end">
                        <button type="button" class="btn btn-success" id="create_ticket">Crear Ticket</button>
                    </div>

                </div>

                <!--- start -->
                <div class="row grid-margin " id="show_ticket">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form autocomplete="off">
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="col-form-label">Tipo: </label>
                                        </div>
                                        <div class="col-lg-8">
                                            <Select id="tik_tipo" name="tik_tipo" style="border-radius: 5px;" required
                                                class="form-control bg-dark text-light rounded-input">
                                                <Option value="Reclamo">Reclamo</Option>
                                                <option value="Sugerencia">Sugerencia</option>
                                                <option value="Peticion">Peticion</option>
                                            </Select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="col-form-label">Urgencia: </label>
                                        </div>
                                        <div class="col-lg-8">
                                            <label for="" name="urgencia" id="urgencia">Media</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="col-form-label">Titulo: </label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input class="form-control" name="titulo" id="titulo" type="text"
                                                placeholder="Type Something..">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label class="col-form-label">Asignar: </label>
                                        </div>
                                        <div class="col-lg-8">
                                            <select name="asig_group" id="asig_group"
                                                class="form-control bg-dark text-light rounded-input"
                                                style="border-radius: 5px;">
                                                <option value="">Grupos</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <div class="card-body" id="drop-area">
                                                <h4 class="card-title">Descripcion</h4>
                                                <textarea id="simpleMde" name="simpleMde"> </textarea>
                                            </div>
                                            <div class="carga de archivos">
                                                <div id="file-list"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-inverse-success btn-fw"
                                        id="button_ticket">Success</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- -end -->


                <div class="nav-scroller">
                    <ul class="nav nav-tabs tickets-tab-switch" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="open-tab" data-toggle="tab" href="#open-tickets" role="tab"
                                aria-controls="open-tickets" aria-selected="true">Tickets <div class="badge" id="countAllTicket"><!--13-->
                                </div></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending-tickets" role="tab"
                                aria-controls="pending-tickets" aria-selected="false">Tickets Asingados<div
                                    class="badge" id="countAllTicketAssigned" ><!--50--> </div></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="onhold-tab" data-toggle="tab" href="#onhold-tickets" role="tab"
                                aria-controls="onhold-tickets" aria-selected="false">Tickets Resueltos <div
                                    class="badge"  id="countAllTicketFinish">
                                    <!---29--> </div>
                            </a>
                        </li>
                    </ul>

                </div>
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="open-tickets" role="tabpanel"
                        aria-labelledby="open-tickets">
                        <div class="tickets-date-group" id="date_ticket" name="date_ticket"><i
                                class="mdi mdi-calendar"></i></div>

                    </div>
                    <div class="tab-pane fade" id="pending-tickets" role="tabpanel" aria-labelledby="pending-tickets">
                        <div class="tickets-date-group" id="date_ticket1" name="date_ticket1"><i
                                class="mdi mdi-calendar"></i></div>
                    </div>
                    <div class="tab-pane fade" id="onhold-tickets" role="tabpanel" aria-labelledby="onhold-tickets">
                        <div class="tickets-date-group" id="date_ticket2" name="date_ticket2"><i
                                class="mdi mdi-calendar"></i>Tuesday, 21 May 2019 </div>

                    </div>
                </div>
                <nav class="mt-4">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="mdi mdi-chevron-left"></i>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>

                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="mdi mdi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>


<script src="../assets/vendors/simplemde/simplemde.min.js"></script>
<script type="text/javascript">
    $("body").addClass("sidebar-icon-only");
    var email = <?php echo json_encode($email); ?>;
    var name = <?php echo json_encode($name); ?>;
    var rut = <?php echo json_encode($rut); ?>;
    var idgrupo = <?php echo json_encode($idgrupo); ?>;
    var rol = <?php echo json_encode($rol); ?>;

    var simplemde;
    if ($("#simpleMde").length) {
        simplemde = new SimpleMDE({
            element: $("#simpleMde")[0],
        });
    }

    const dropArea = document.getElementById('drop-area');

    // Prevenir el comportamiento por defecto de arrastrar y soltar
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Resaltar drop area cuando el item es arrastrado sobre ella
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropArea.classList.add('hover');
    }

    function unhighlight(e) {
        dropArea.classList.remove('hover');
    }

    // Manejar el archivo soltado
    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
        handleFiles(files);
    }

    let uploadedFiles = []; // Array para almacenar las referencias de los archivos cargados

    function handleFiles(files) {
        uploadedFiles.push(...files); // Añadir nuevos archivos al array
        displayFiles(); // Actualizar la lista de archivos
    }

    function displayFiles() {
        const fileList = document.getElementById('file-list');
        fileList.innerHTML = ''; // Limpiar lista actual

        uploadedFiles.forEach(file => {
            const fileElement = document.createElement('div');
            fileList.appendChild(fileElement);

            // Mostrar una previsualización para imágenes
            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.height = 60; // Ejemplo de altura para la miniatura
                img.onload = () => URL.revokeObjectURL(img.src); // Liberar memoria
                fileElement.appendChild(img);
            } else {
                // Para otros tipos de archivos, muestra un icono o nombre del archivo
                let icon;
                switch (file.type) {
                    case 'application/pdf': icon = '📄'; break;
                    case 'text/csv': icon = '📑'; break;
                    case 'application/zip':
                    case 'application/x-zip-compressed': icon = '🗜️'; break;
                    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                    case 'application/msword': icon = '📝'; break;
                    default: icon = '📁'; // Icono genérico para otros tipos de archivos
                }
                fileElement.textContent = `${icon} ${file.name}`;
            }
        });
    }


</script>

<script src="../assets/WebSockets/conexionWebSockets.js"></script>

<script src="../assets/js/bottonsTicket.js"></script>
<script src="../assets/js/shared/toastDemo.js"></script>


<script src="../assets/WebSockets/funcionalidades.js"></script>
<script src="../assets/WebSockets/data.js"></script>

<script src="../assets/js/shared/hoverable-collapse.js"></script>


<script src="../assets/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/showdown@1.9.1/dist/showdown.min.js"></script>