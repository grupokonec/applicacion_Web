<div class="alert alert-success" role="alert">
                        <strong>Nota:</strong> Tener en cuenta que el RUT a ingresar debe contener con 10 dígitos y sin guión verificador.
                        </div>

                        <h4>Bloquear RUT</h4>
                        <form action="bloq_global.php" method="post">
                        <?php
                        date_default_timezone_set('America/Santiago');
                        $fcha = date("d-m-Y H:i:s");    
                        echo "<br> La fecha y hora actual es: ". $fcha;  ?>   
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
                        <form action="bloq_fono_global.php" method="post">
                        <?php
                        date_default_timezone_set('America/Santiago');
                        $fcha = date("Y-m-d H:i:s");    
                        echo "<br> La fecha y hora actual es: ". $fcha;  ?>         
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
                        <form action="bloq_mail_global.php" method="post">
                        <?php $fcha = date("Y-m-d");?>         
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
