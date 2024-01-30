<div id="loading-indicator" class="jumping-dots-loader"
    style="height: 100%; display: none; justify-content: center; align-items: center;">
    <img style="height: 200px;" src="../assets/images/Logof.gif" alt="">
</div>

<div class="card" style="height:400px; width: 100%;" id="no">
    <div class="card-body">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3>Generar Informe</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="form-group">
                                <label for="fecha">Fecha Inicio</label>
                                <input type="date" class="form-control bg-outline-info  datepicker" id="fecha1"
                                    name="fecha1" style="border-radius: 10px; font-size: 16px; box-shadow: 0 0 0 2px #8862e0 inset;">
                            </div>
                            <div class="form-group">
                                <label for="fecha">Fecha Fin</label>
                                <input type="date" class="form-control bg-outline-info  datepicker"
                                    id="fecha2" name="fecha2"
                                    style="border-radius: 10px; font-size: 16px; box-shadow: 0 0 0 2px #8862e0 inset;">

                            </div>
                            <div class="form-group">
                                <input class="btn btn-outline-warning btn-block" type="submit" value="Generar"
                                    id="generar_info" name="generar_info" style="padding: 12px;">
                            </div>
                        </form>
                    </div>

                    <div class="col-12 col-md-6 h-100 card d-flex flex-column" style="max-height: 357px; overflow-y: auto; "
                    id="tuContenedor1">
                </div>
                </div>
                
            </div>
        </div>
    </div>
</div>



<script src="../assets/js/informes_global.js"></script>