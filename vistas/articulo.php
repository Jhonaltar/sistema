<?php
require 'header.php';
?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">



      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
          <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
          </a>
          <!-- Dropdown - Messages -->
          <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search">
              <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

        

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Valerie Luna</span>
            <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </a>
            <a class="dropdown-item" href="#">
              <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
              Settings
            </a>
            <a class="dropdown-item" href="#">
              <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
              Activity Log
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>

      </ul>

    </nav>
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
                  <h1 class="box-title">Articulo <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                          <th class="text-center">Categoria</th>
                          <th class="text-center">Codigo</th>
                          <th class="text-center">Stock</th>
                          <th class="text-center" style="width: 120px;">Imagen</th>
                          <th class="text-center" style="width: 200px;">Estado</th>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                        <th class="text-center">Opciones</th>
                          <th class="text-center">Nombre</th>
                          <th class="text-center">Categoria</th>
                          <th class="text-center">Codigo</th>
                          <th class="text-center">Stock</th>
                          <th class="text-center">Imagen</th>
                          <th class="text-center" >Estado</th>
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
                            <input type="hidden" name="idarticulo" id="idarticulo">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                            <label>Categoria:</label>
                                <select id="idcategoria" name="idcategoria" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>stock:</label>
                            
                            <input type="number" class="form-control" name="stock" id="stock" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Descripción:</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripción">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" class="form-control" name="imagen" id="imagen" >
                            <input type="hidden" class="form-control" name="imagenactual" id="imagenactual" >
                            <img src="" width="150px" height="120px" id="imagenmuestra">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Codigo:</label>
                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Codigo de barras">
                            <button class="btn btn-success" type="button" onclick="generarbarcode()"><i class="fas fa-barcode"></i> Generar</button>
                            <button class="btn btn-info" type="button" onclick="imprimir()"><i class="fas fa-print"></i> Imprimir</button>
                            <div id="print">
                                <svg id="barcode"></svg>
                            </div>
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

  require 'footer.php';

  ?>

<script src="../public/js/JsBarcode.all.min.js"></script>
<script src="../public/js/jquery.PrintArea.js"></script>
<script src="scripts/articulo.js"></script>
 