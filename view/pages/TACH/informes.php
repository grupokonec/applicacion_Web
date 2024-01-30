<div class="card" style=" width: 100%;" id="no">
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-center mt-3">
                        <h3>Informacion</h3>
                    </div>
                    <form>
                        <div class="form-group">
                            <label for="fecha">Fecha Inicio</label>
                            <input type="date" class="form-control bg-success text-white datepicker" id="fechaInicio"
                                name="fechaInicio" style="border-radius: 10px; font-size:16px;">
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha Fin</label>
                            <input type="date" class="form-control bg-success text-white datepicker" id="fechaFin"
                                name="fechaFin" style="border-radius: 10px; font-size:16px;">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-outline-warning btn-block" id="generarTach" type="submit"
                                value="Generar" style="padding: 12px;">
                        </div>
                    </form>
                </div>
                <div class="col-12 h-100 card d-flex flex-column" style="max-height: 357px; overflow-y: auto; "
                    id="tuContenedor1">
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="../assets/js/tach.js"></script>