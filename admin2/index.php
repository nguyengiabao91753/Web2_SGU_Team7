<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $cssStack = [];
  $jsStack = [];
  $selectedContent = isset($_GET['page']) ? $_GET['page'] : 'index';
  $contentPath = "$selectedContent";

  include("layouts/head.php");
  ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- navbar -->
    <?php include("layouts/navbar.php"); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include("layouts/sidebar.php"); ?>

    <!-- /.sidebar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <?php if (isset($_SESSION['flash_message'])) : ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-check"></i> Alert!</h5>
          <?php echo $_SESSION['flash_message']; ?>
        </div>
      <?php endif; ?>
      <?php
         unset($_SESSION['flash_message']);
      ?>

      <?php if (isset($_SESSION['err'])) : ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-check"></i> Alert!</h5>
          <?php echo $_SESSION['err']; ?>
        </div>
        <?php unset($_SESSION['err']);
        ?>
      <?php endif; ?>

      <?php
      if (file_exists($contentPath)) {
        include($contentPath);
      } else {
        include("pages/Statistical.php");
      }
      ?>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <?php include("layouts/footer.php"); ?>
    <!-- /.Footer-->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->


  <?php include("layouts/footlink.php"); ?>
  <?php
  // CSS
  foreach ($cssStack as $item) {
    echo "{$item}";
  }

  //JS
  foreach ($jsStack as $item) {
    echo "{$item}";
  }
  ?>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
</body>

</html>