<div class="card" style="height:400px; width: 100%;" id="no">
    <div class="card-body">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-6" id="si">
                        <div class="text-center mt-3">
                            <h3>Semanal</h3>
                        </div>
                        <form method="post" action="../controller/ACSA/generar_informe.php" id="miFormulario">
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
                    <div class="col-md-6">
                        <select id="tipo_cobranza" name="tipo_cobranza"
                            class="custom-select form-control bg-success text-white"
                            style="border-radius: 10px; font-size: 16px;" form="miFormulario" required>
                            <option> Elija Cartera</option>
                            <option value="ANT_A00008">ANT_A00008</option>
                            <option value="DA_IN00008">DA_IN00008</option>
                            <option value="DA_PR00008">DA_PR00008</option>
                            <option value="DN_IN00007">DN_IN00007</option>
                            <option value="DN_PR00007">DN_PR00007</option>
                            <option value="LATEP00030">LATEP00030</option>
                            <option value="MONTO00018">MONTO00018</option>
                            <option value="ORG_P00004">ORG_P00004</option>
                            <option value="PTT01">PTT01</option>
                            <option value="SIN_C00001">SIN_C00001</option>
                        </select><br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#si').hide();
    $("#tipo_cobranza").on('click', function () {
        $('#si').show();
    })
</script>