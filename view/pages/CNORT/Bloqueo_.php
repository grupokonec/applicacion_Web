<?php
session_start();
$nombre = $_SESSION['name'];
?>


<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Bloqueo Costanera Norte y Vespucio Sur</h4>
        <div class="row grid-margin">
          <div class="col-12">
            <div class="alert alert-success" role="alert">
              <strong>Nota:</strong> Tener en cuenta que el RUT a ingresar debe contener con dígito
              verificador.
            </div>

            <h>Bloquear RUT</h>
            <form autocomplete="off" action="../controller/CNORT/bloq_cnort.php" method="post" id="formBloquearRut">
              <?php
              date_default_timezone_set('America/Santiago');
              $fcha = date("Y-m-d H:i:s"); ?>
              <div class="form-group row">
                <div class="col-sm-3">
                  <input type="text" class="form-control" placeholder="Ingrese el RUT" id="rut" name="rut" required>
                  <input type="hidden" id="fecha" name="fecha" value="<?php echo $fcha; ?>">
                  <input type="hidden" id="usu" name="usu" value="<?php echo $nombre; ?>">
                </div>
              </div>
              <button class="btn btn-sm btn-primary waves-effect waves-themed ml-auto" type="submit">Guardar</button>
            </form>

            <br>

            <h>Bloquear Telefono</h>
            <form autocomplete="off" action="../controller/CNORT/bloq_fono_cnort.php" method="post"
              id="formBloquearTelefono">
              <?php
              date_default_timezone_set('America/Santiago');
              $fcha = date("Y-m-d H:i:s"); ?>
              <div class="form-group row">
                <div class="col-sm-3">
                  <input type="text" class="form-control" placeholder="Ingrese el RUT" id="rut" name="rut" required>
                </div>
                <div class="col-sm-3">
                  <input type="text" class="form-control" placeholder="Ingrese el telefono (9 dígitos)" id="fono"
                    name="fono" required>
                  <input type="hidden" id="fecha" name="fecha" value="<?php echo $fcha; ?>">
                  <input type="hidden" id="usu" name="usu" value="<?php echo $nombre; ?>">
                </div>
              </div>
              <button class="btn btn-sm btn-primary waves-effect waves-themed ml-auto" type="submit">Guardar</button>
            </form>
            <br>

            <h>Bloquear Email</h>
            <form autocomplete="off" method="post" id="formBloquearEmail">
              <?php
              date_default_timezone_set('America/Santiago');
              $fcha = date("Y-m-d H:i:s"); ?>
              <div class="form-group row">
                <div class="col-sm-3">
                  <input type="text" class="form-control" placeholder="Ingrese el RUT" id="rut" name="rut" required>
                </div>
                <div class="col-sm-3">
                  <input type="text" class="form-control" placeholder="Ingrese E-mail" id="mail" name="mail" required>
                  <input type="hidden" id="fecha" name="fecha" value="<?php echo $fcha; ?>">
                  <input type="hidden" id="usu" name="usu" value="<?php echo $nombre; ?>">
                </div>
              </div>
              <button class="btn btn-sm btn-primary waves-effect waves-themed ml-auto" type="submit">Guardar</button>
            </form>


          </div>
        </div>
      </div>
    </div>
  </div>
</div>