<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Autopista Central</h4>
        <div class="row grid-margin">
          <div class="col-12">
            <div class="alert alert-success" role="alert">
              <strong>Nota:</strong> Tener en cuenta que el RUT a ingresar debe contener con dígito verificador.
            </div>

            <h>Bloquear RUT</h>
            <form action="../controller/ACSA/bloq_acsa.php" method="post">
              <?php
              date_default_timezone_set('America/Santiago');
              $fcha = date("Y-m-d H:i:s"); ?>
              <div class="form-group row">
                <div class="col-sm-3">
                  <input type="text" class="form-control" placeholder="Ingrese el RUT" id="rut" name="rut" required>
                  <input type="hidden" id="fecha" name="fecha" value="<?php echo $fcha; ?>">
                </div>
              </div>
              <button class="btn btn-sm btn-primary waves-effect waves-themed ml-auto" type="submit">Guardar</button>
            </form>

            <br>

            <h>Bloquear Telefono</h>
            <form action="../controller/ACSA/bloq_fono_acsa.php" method="post">
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
                </div>
              </div>
              <button class="btn btn-sm btn-primary waves-effect waves-themed ml-auto" type="submit">Guardar</button>
            </form>
            <br>

            <h>Bloquear Email</h>
            <form action="../controller/ACSA/bloq_mail_acsa.php" method="post">
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