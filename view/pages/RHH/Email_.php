<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 h-100 card d-flex flex-column">
            <form>
                <div style="padding: 20px;">
                    <div class="form-group" style="display: flex; align-items: center; margin-bottom: 10px;">
                        <div style="margin-right: 10px; display: flex; align-items: center;">
                            <label for="email" style="vertical-align: middle;">Email De Todas Las
                                Carteras</label>
                        </div>
                        <div>
                            <input type="radio" name="option" id="email" value="email">
                        </div>
                    </div>
                    <div class="form-group" style="display: flex; align-items: center; margin-bottom: 10px;">
                        <div style="margin-right: 10px; display: flex; align-items: center;">
                            <label for="sms" style="vertical-align: middle;">SalcoBrand Landing </label>
                        </div>
                        <div>
                            <input type="radio" name="option" id="sms" value="sms">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label for="fecha">Fecha Inicio</label>
                        <input type="month" class="form-control alert-fill-info text-white datepicker" id="fechamoth"
                            name="fechamoth" style="border-radius: 10px; font-size:16px;">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-outline-danger btn-block" type="submit" value="Generar"
                            style="padding: 12px;" id="generarRhh">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-6 h-100 card d-flex flex-column"
            style="max-height: 357px; overflow-y: auto;"
            id="tuContenedor">
        </div>
    </div>


</div>
</div>


<script src="../assets/js/rhh.js"></script>