<div class="alert alert-success" role="alert">
                        <strong>Nota:</strong> Tener en cuenta que el RUT a ingresar debe contener con dígito verificador.
                        </div>

                        <h4>Bloquear RUT</h4>
                        <form action="bloq_vsur.php" method="post">
                        <?php 
                        date_default_timezone_set('America/Santiago');
                        $fcha = date("Y-m-d H:i:s");  ?>         
                        <div class="form-group row">
                        <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Ingrese el RUT"  id="rut" name="rut"  required>
                        <input type="hidden" id="fecha" name="fecha" value="<?php echo $fcha;?>">
                        </div>
                        </div>
                        <button class="btn btn-sm btn-primary waves-effect waves-themed ml-auto" type="submit">Guardar</button>
                        </form>

                       <br>

                        <h4>Bloquear Telefono</h4>
                        <form action="bloq_fono_vsur.php" method="post">
                        <?php 
                        date_default_timezone_set('America/Santiago');
                        $fcha = date("Y-m-d H:i:s");  ?>        
                        <div class="form-group row">
                        <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Ingrese el RUT"  id="rut" name="rut"  required>
                        </div>
                        <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Ingrese el telefono (9 dígitos)"  id="fono" name="fono"  required>
                        <input type="hidden" id="fecha" name="fecha" value="<?php echo $fcha;?>">
                        </div>
                        </div>
                        <button class="btn btn-sm btn-primary waves-effect waves-themed ml-auto" type="submit">Guardar</button>
                        </form>
                        <br>

                        <h4>Bloquear Email</h4>
                        <form action="bloq_mail_vsur.php" method="post">
                        <?php 
                        date_default_timezone_set('America/Santiago');
                        $fcha = date("Y-m-d H:i:s");  ?>       
                        <div class="form-group row">
                        <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Ingrese el RUT"  id="rut" name="rut"  required>
                        </div>
                        <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Ingrese E-mail"  id="mail" name="mail"  required>
                        <input type="hidden" id="fecha" name="fecha" value="<?php echo $fcha;?>">
                        </div>
                        </div>
                        <button class="btn btn-sm btn-primary waves-effect waves-themed ml-auto" type="submit">Guardar</button>
                        </form>