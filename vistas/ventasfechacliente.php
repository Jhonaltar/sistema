<?php

//activamos el alamacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else 

{
  require 'header.php';

  if ($_SESSION['consultav'] == 1 ) 
  {
    
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
                    <h1 class="box-title">Consultas de ventas por Fecha y Cliente</h1>
                    <div class="box-tools pull-right">
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <!-- centro -->
                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <div class="panel-body table-responsive" id="listadoregistros">
                      <div class="row">
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                              <label>Fecha Inicio:</label>                             
                              <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d");?>">
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                              <label>Fecha Fin:</label>                             
                              <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d");?>">
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Cliente:</label>
                                <select id="idcliente" name="idcliente" class="form-control selectpicker" data-live-search="true" required="">
                                </select>
                                <button class="btn btn-primary" onclick="listar()" style="margin-top: 12px;"><i class="fa fa-list-alt"></i> Mostar</button>
                              </div>
                        </div>
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                              <th class="text-center">Fecha</th>
                              <th class="text-center">Usuario</th>
                              <th class="text-center">Cliente</th>
                              <th class="text-center">Documento</th>
                              <th class="text-center">N#. Documento</th>
                              <th class="text-center">Total Ventas</th>
                              <th class="text-center">Impuesto</th>
                              <th class="text-center" style="width: 200px;">Estado</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>
                            <th class="text-center">Fecha</th>
                              <th class="text-center">Usuario</th>
                              <th class="text-center">Cliente</th>
                              <th class="text-center">Documento</th>
                              <th class="text-center">N#. Documento</th>
                              <th class="text-center">Total Ventas</th>
                              <th class="text-center">Impuesto</th>
                              <th class="text-center">Estado</th>
                          </tfoot>
                        </table>
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
  }
  else {
    require 'noacceso.php';
  }
    require 'footer.php';

    ?>

    <script src="scripts/ventasfechacliente.js"></script>
  <?php

  }

  ob_end_flush();

  ?>