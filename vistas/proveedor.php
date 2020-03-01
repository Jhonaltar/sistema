<?php

//activamos el alamacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['compras'] == 1) {
?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php

        require 'userinfo.php';

        ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">



          <!--Contenido-->
          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
              <div class="row">
                <div class="col-lg-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h1 class="box-title">Proveedor <button class="btn btn-success" id="btnagregarc" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                      <div class="box-tools pull-right">
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="card shadow mb-4">
                      <div class="card-header py-3">
                        <div class="panel-body table-responsive" id="listadoregistros">
                          <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                              <th class="text-center" style="width: 150px;">Opciones</th>
                              <th class="text-center">Nombre</th>
                              <th class="text-center">Tipo Documento</th>
                              <th class="text-center">Numero Documento</th>
                              <th class="text-center">Telefono</th>
                              <th class="text-center">Email</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                              <th class="text-center">Opciones</th>
                              <th class="text-center">Nombre</th>
                              <th class="text-center">Tipo Documento</th>
                              <th class="text-center">Numero Documento</th>
                              <th class="text-center">Telefono</th>
                              <th class="text-center">Email</th>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>

                    <div class="panel-body" style="height: 600px;" id="formularioregistros">

                      <div class="card shadow mb-4">
                        <div class="card-header py-3">

                          <form name="formulario" id="formulario" method="POST">
                            <div class="row">
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Nombre:</label>
                                <input type="hidden" name="idpersona" id="idpersona">
                                <input type="hidden" name="tipo_persona" id="tipo_persona" value="Proveedor">
                                <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del Proveedor" required>
                              </div>
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Tipo de documento:</label>
                                <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>
                                  <option value="DNI">DNI</option>
                                  <option value="RUC">RUC</option>
                                  <option value="CEDULA">CEDULA</option>
                                </select>
                              </div>
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Numero Documento:</label>
                                <input type="number" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="Documento">
                              </div>
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Direccion:</label>
                                <input type="text" class="form-control" name="direccion" id="direccion" maxlength="70" placeholder="Direccion">
                              </div>
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Telefono:</label>
                                <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Telefono">
                              </div>
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Email:</label>
                                <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                              </div>
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
                </div><!-- /.col -->
              </div><!-- /.row -->
            </section><!-- /.content -->

          </div><!-- /.content-wrapper -->
          <!--Fin-Contenido-->

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

    <?php
  } else {
    require 'noacceso.php';
  }
  require 'footer.php';

    ?>

  <script src="scripts/proveedor.js"></script>
  <?php

}

ob_end_flush();

  ?>