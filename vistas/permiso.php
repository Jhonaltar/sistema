<?php


//activamos el alamacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['acceso'] == 1 ) 
  {
    
?>
  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

      <!-- Topbar -->
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
                    <h1 class="box-title">Permisos <button class="btn btn-success" id="btnagregarc" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                            <th class="text-center">Nombre</th>
                          </thead>
                          <tbody>

                          </tbody>
                          <tfoot>

                            <th class="text-center">Nombre</th>

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

    <script src="scripts/permiso.js"></script>
  <?php

}

ob_end_flush();

  ?>