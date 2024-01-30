<div class="card" style="height:400px; width: 100%;" id="no">
    <div class="card-body">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3>Generar Informes</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div style=" padding-right:60px">
                            <div class="text-center mt-3">
                                <h3>Diario</h3>
                            </div>
                            <form method="post" action="../controller/VSUR/generar_informe_diario.php">
                                <div class="form-group">
                                    <label for="fecha">Fecha Inicio</label>
                                    <input type="date" class="form-control bg-success text-white datepicker"
                                        id="fechaInicio" name="fechaInicio"
                                        style="border-radius: 10px; font-size:16px;">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-outline-danger btn-block" type="submit" value="Generar"
                                        style="padding: 12px;">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center mt-3">
                            <h3>Semanal</h3>
                        </div>
                        <form method="post" action="../controller/VSUR/generar_informe_semanal.php">
                            <div class="form-group">
                                <label for="fecha">Fecha Inicio</label>
                                <input type="date" class="form-control bg-success text-white datepicker"
                                    id="fechaInicio" name="fechaInicio" style="border-radius: 10px; font-size:16px;">
                            </div>
                            <div class="form-group">
                                <label for="fecha">Fecha Fin</label>
                                <input type="date" class="form-control bg-success text-white datepicker" id="fechaFin"
                                    name="fechaFin" style="border-radius: 10px; font-size:16px;">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-outline-warning btn-block" type="submit" value="Generar"
                                    style="padding: 12px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>