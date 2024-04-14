<?php
session_start();
ob_start();
?>
<?php if (isset($_COOKIE['user_id'])) : ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php


    //$_SESSION['success'] = "Category updated successfully!";  
    $cssStack = [];
    $jsStack = [];
    $selectedContent = isset($_GET['page']) ? $_GET['page'] : 'Statistical';
    $contentPath = "pages/$selectedContent.php";

    require_once("layouts/head.php");
    require_once '../backend/Userfunction.php';
    ?>

  </head>

  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <!-- navbar -->
      <?php require_once("layouts/navbar.php"); ?>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <?php require_once("layouts/sidebar.php"); ?>

      <!-- /.sidebar -->



      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Content Header (Page header) -->
        <?php if (isset($_COOKIE['success'])) : ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
            <?php echo $_COOKIE['success']; ?>
          </div>
          <?php
            setcookie("success","",time() -1,"/");
          ?>
        <?php endif; ?>


        <?php if (isset($_COOKIE['err'])) : ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
            <?php echo $_COOKIE['err']; ?>
          </div>
          <?php  setcookie("err","", time() -11,"/");
          ?>
        <?php endif; ?>

        <?php

        include($contentPath);

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
      echo $item;
    }

    //JS
    foreach ($jsStack as $item) {
      echo $item;
    }

    ob_end_flush();
    ?>

    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="dist/js/pages/dashboard.js"></script> -->
  </body>

  </html>

<?php else : ?>
  <?php header("Location: auth/login.php"); ?>
<?php endif; ?>
