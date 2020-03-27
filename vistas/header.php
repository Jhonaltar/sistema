<?php
if (strlen(session_id()) < 1 )
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistema de Ventas MiniMarket Sonia</title>

  <!-- Custom fonts for this template-->
  <link href="../public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../public/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Datatable -->

  <!-- Datatable <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css" >-->
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="../public/datatables/responsive.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion " id="accordionSidebar" >

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="escritorio.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">MiniMarket Sonia</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <?php
      if ($_SESSION['escritorio'] == 1) {
        echo '<li class="nav-item active">
        <a class="nav-link" href="escritorio.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Escritorio</span></a>
      </li>';
      }
      ?>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interfas
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <?php
      if ($_SESSION['almacen'] == 1) {
        echo '<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fa fa-laptop"></i>
          <span>Almacen</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Productos y Categorias:</h6>
            <a class="collapse-item" href="articulo.php"><i class="fa fa-circle-o"></i>Artículos</a>
            <a class="collapse-item" href="categoria.php">Categorías</a>
          </div>
        </div>
      </li>';
      }
      ?>
      <!-- Nav Item - Utilities Collapse Menu -->
      <?php
      if ($_SESSION['compras'] == 1) {
        echo '<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-th"></i>
          <span>Compras</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Compras de Articulos:</h6>
            <a class="collapse-item" href="ingreso.php">Ingresos</a>
            <a class="collapse-item" href="proveedor.php">Proveedor</a>
          </div>
        </div>
      </li>';
      }
      ?>

      <?php
      if ($_SESSION['ventas'] == 1) {
        echo '<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities1" aria-expanded="true" aria-controls="collapseUtilities1">
          <i class="fas fa-shopping-cart"></i>
          <span>Ventas</span>
        </a>
        <div id="collapseUtilities1" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Ventas de Articulos:</h6>
            <a class="collapse-item" href="venta.php">Ventas</a>
            <a class="collapse-item" href="cliente.php">Clientes</a>
          </div>
        </div>
      </li>';
      }
      ?>

      <?php
      if ($_SESSION['acceso'] == 1) {
        echo ' <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="true" aria-controls="collapseUtilities2">
          <i class="fa fa-universal-access"></i>
          <span>Accesso al Sistema</span>
        </a>
        <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Permisos a Usuarios:</h6>
            <a class="collapse-item" href="usuario.php">Usuario</a>
            <a class="collapse-item" href="permiso.php">Permisos</a>
          </div>
        </div>
      </li>';
      }
      ?>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Consultas y Reportes
      </div>

      <!-- Nav Item - Pages Collapse Menu -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Cosultas</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php
            if ($_SESSION['consultac'] == 1) {
              echo ' <h6 class="collapse-header">Consultas Compras:</h6>
        <a class="collapse-item" href="comprasfecha.php">Consultas Compras</a>';
            }
            ?>

            <?php
            if ($_SESSION['consultav'] == 1) {
              echo '<h6 class="collapse-header">Consultas Ventas:</h6>
        <a class="collapse-item" href="ventasfechacliente.php">Consultas Ventas</a>';
            }
            ?>

            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Ayuda:</h6>
            <a class="collapse-item" href="#">DPF</a>
            <a class="collapse-item" href="#">IT..</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities3" aria-expanded="true" aria-controls="collapseUtilities3">
          <i class="far fa-question-circle"></i>
          <span>Ayuda</span>
        </a>
        <div id="collapseUtilities3" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Soporte Tecnico:</h6>
            <a class="collapse-item" href="#">DPF</a>
            <a class="collapse-item" href="#">IT..</a>
          </div>
        </div>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->