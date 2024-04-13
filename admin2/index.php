<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  session_start();
  //  $_SESSION['success'] = "Category updated successfully!";  
  $cssStack = [];
  $jsStack = [];
  $selectedContent = isset($_GET['page']) ? $_GET['page'] : 'Statistical';
  $contentPath = "pages/$selectedContent.php";

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

    <script>
      $(document).ready(function() {
        <?php if (isset($_GET['add'])) : ?>
          alert("Add successfully!");
          var currentURL = window.location.href;

          // Loại bỏ tham số &a=true khỏi URL
          var updatedURL = currentURL.replace(/&add=true/g, '');

          // Nếu tham số a=true ở cuối URL, cần loại bỏ dấu & còn thừa
          updatedURL = updatedURL.replace(/\?$/, ''); // Loại bỏ dấu ? nếu không còn tham số nào sau khi loại bỏ &a=true

          // Sử dụng pushState để cập nhật URL hiện tại mà không làm tải lại trang
          window.history.pushState({path: updatedURL}, '', updatedURL);

        <?php endif; ?>

      });
    </script>




    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <?php if (isset($_SESSION['success'])) : ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-check"></i> Alert!</h5>
          <?php echo $_SESSION['success']; ?>
        </div>
        <?php
        unset($_SESSION['success']);
        ?>
      <?php endif; ?>


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