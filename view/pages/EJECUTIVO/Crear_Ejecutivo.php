<?php
session_start();
$rut_super = $_SESSION['usu_id'];
?>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 h-100 card d-flex flex-column">
            <div class="">
                <div class="alert alert-success" role="alert" id="mensajeError"></div>
                <form autocomplete="off">
                    <input hidden type="text" class="form-control" value="<?php echo $rut_super ?>" name="super"
                        id="super">
                    <div style="padding: 40px;">
                        <h3 class="mr-auto">Nuevo Ejecutivo</h3>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="mdi mdi-account-outline"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Rut" name="usu_rut" id="usu_rut">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="mdi mdi-account-outline"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" name="usu_usu" id="usu_usu">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="mdi mdi-lock-outline"></i>
                                </span>
                            </div>
                            <input type="password" class="form-control" placeholder="Password" name="usu_pass"
                                id="usu_pass">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="mdi mdi-lock-outline"></i>
                                </span>
                            </div>
                            <input type="email" class="form-control" placeholder="Correo" name="correo" id="correo">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary submit-btn" id="btn_ejecutivo">SIGN IN</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-md-6 h-100 card d-flex flex-column" id="tuContenedor"
            style="max-height:357px; overflow-y: auto;">

        </div>
    </div>
</div>


<script src="../assets/js/ejecuitvos.js"></script>