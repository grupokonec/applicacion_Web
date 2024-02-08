<div class="card" style="height:400px; width: 100%;" id="no">
    <div class="card-body">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <form id="formCartera" method="post" action="../controller/ACSA/mejor_gestion.php">
                            <select id="tipo_cartera" name="tipo_cartera"
                                class="custom-select form-control  text-white"
                                style="border-radius: 10px; font-size: 16px; background:#02735E" required>
                                <option disabled selected class="text-white">Elija Cartera</option>
                                <!-- Hacer que el usuario no pueda seleccionar esta opción -->
                                <option value="CASTI00042">CASTI00042</option>
                                <option value="PTT01">PTT01</option>
                                <option value="DN_PR00009">DN_PR00009</option>
                                <option value="ANT_A00009">ANT_A00009</option>
                                <option value="NOVEN00028">NOVEN00028</option>
                                <option value="DN_IN00008">DN_IN00008</option>
                                <option value="MONTO00019">MONTO00019</option>
                                <option value="ORG_P00006">ORG_P00006</option>
                            </select>
                            
                            <input style="width: 100%; " class="btn-save btn btn-primary btn-sm mt-4" type="submit" value="Generar">
                            
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/acsa.js"></script>