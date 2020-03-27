<?php

//activamos el alamacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['ventas'] == 1) {

?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php

        require 'userinfo.php';

        ?>
        <!-- End of Topbar -->

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
                      <h1 class="box-title">Venta <button class="btn btn-success" id="btnagregarc" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> <a href="../reportes/rptventas.php" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generar Reporte</a></h1>
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
                              <th class="text-center">Fecha</th>
                              <th class="text-center">Proveedor</th>
                              <th class="text-center">Usuario</th>
                              <th class="text-center">Documento</th>
                              <th class="text-center">N#. Documento</th>
                              <th class="text-center">Total Venta</th>
                              <th class="text-center" style="width: 200px;">Estado</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                              <th class="text-center">Opciones</th>
                              <th class="text-center">Fecha</th>
                              <th class="text-center">Proveedor</th>
                              <th class="text-center">Usuario</th>
                              <th class="text-center">Documento</th>
                              <th class="text-center">N#. Documento</th>
                              <th class="text-center">Total Venta</th>
                              <th class="text-center">Estado</th>
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
                              <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <label>Cliente:</label>
                                <input type="hidden" name="idventa" id="idventa">
                                <select id="idcliente" name="idcliente" class="form-control selectpicker" data-live-search="true" required="">
                                </select>
                              </div>
                              <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Fecha:</label>
                                <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" required="">
                              </div>
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Tipo de Comprobante:</label>
                                <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                                  <option value="Boleta">Boleta</option>
                                  <option value="Factura">Factura</option>
                                  <option value="Ticket">Ticket</option>
                                </select>
                              </div>
                              <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Serie:</label>
                                <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie de Comprobante">
                              </div>
                              <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Numero:</label>
                                <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Numero de Comprobante" required="">
                              </div>
                              <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>Impuesto:</label>
                                <input type="text" class="form-control" name="impuesto" id="impuesto" required="">
                              </div>
                              <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a data-toggle="modal" href="#myModal">
                                  <button class="btn btn-info" type="button" id="btnAgregarArt" data-target=".bd-example-modal-lg"><span class="fas fa-box-open"></span> Agregar Articulo</button>
                                </a>
                              </div>
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover  " style="border-collapse: collapse;border-radius: 1em;overflow: hidden;">
                                  <thead class="thead-dark">
                                    <th class="text-center" style="width: 140px;">Opciones</th>
                                    <th class="text-center">Articulo</th>
                                    <th class="text-center" style="width: 250px;">Cantidad</th>
                                    <th class="text-center" style="width: 250px;">Precio de Venta</th>
                                    <th class="text-center" style="width: 250px;">Descuento</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center"></th>
                                  </thead>
                                  <tfoot class="table-primary" style="border-collapse: collapse;border-radius: 1em;overflow: hidden;">
                                    <th class="text-center">
                                      <h4><span class="badge badge-warning">TOTAL</span></h4>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-center">
                                      <h5 id="total">$. 0.00</h5><input type="hidden" name="total_venta" id="total_venta">
                                    </th>
                                    <th class="table-light" style="width: 90px;"><button style="margin-left: 12px;" type="button" id="modi" class="btn btn-primary btn-circle" onclick="modificarSubototales()"><i class="fas fa-sync-alt"></i></button></th>
                                  </tfoot>
                                </table>
                              </div>

                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
      <!-- Modal -->


      <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Seleccione un Articulo</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <th class="text-center" style="width: 120px;">Opciones</th>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Categoria</th>
                  <th class="text-center">Codigo</th>
                  <th class="text-center">Stock</th>
                  <th class="text-center">Precio Venta</th>
                  <th class="text-center" style="width: 120px;">Imagen</th>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                  <th class="text-center">Opciones</th>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Categoria</th>
                  <th class="text-center">Codigo</th>
                  <th class="text-center">Stock</th>
                  <th class="text-center">Precio Venta</th>
                  <th class="text-center">Imagen</th>
                </tfoot>
              </table>
            </div>
            <div class="modal-footer">
              <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancel</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Fin Modal -->

    <?php
  } else {
    require 'noacceso.php';
  }
  require 'footer.php';

    ?>

    <script src="scripts/venta.js"></script>
  <?php

}

ob_end_flush();

  ?>