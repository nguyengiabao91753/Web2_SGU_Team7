<?php
array_push($cssStack, '<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">');
array_push($cssStack, '<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">');
array_push($cssStack, '<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">');
array_push($cssStack, '<link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">');
array_push($cssStack, '<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">');
array_push($cssStack, '<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">');
array_push($cssStack, '<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">');


array_push($jsStack, '
    <script>
      $.widget.bridge("uibutton", $.ui.button);
    </script>');
array_push($jsStack, '<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>');
array_push($jsStack, '<script src="plugins/chart.js/Chart.min.js"></script>');
array_push($jsStack, '<script src="plugins/sparklines/sparkline.js"></script>');
array_push($jsStack, '<script src="plugins/jqvmap/jquery.vmap.min.js"></script> ');
array_push($jsStack, '<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>');
array_push($jsStack, '<script src="plugins/jquery-knob/jquery.knob.min.js"></script>');
array_push($jsStack, '<script src="plugins/moment/moment.min.js"></script>');
array_push($jsStack, '<script src="plugins/daterangepicker/daterangepicker.js"></script>');

array_push($jsStack, '<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>');
array_push($jsStack, '<script src="plugins/summernote/summernote-bs4.min.js"></script>');
array_push($jsStack, '<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>');
?>
<?php
require_once("../chucnang/recursiveCate.php");
require_once '../backend/Category.php';
require_once '../backend/Product.php';
require_once '../backend/Order.php';
require_once '../backend/User.php';
require_once '../backend/Statistical.php';
$years = getDistinctYears();
$countcate = countCate();
$countpro = countProduct();
$countorder = countOrders();
$countcus = countUsers();

$categories = getAllCategory()

?>
<style>
  /* .select-statis{
    width: 33%;
  } */
</style>
<script>
  $(document).ready(function() {
    var currentMonth = new Date().getMonth(); // Lấy tháng hiện tại (từ 0 đến 11)
    var months = [
      "January", "February", "March", "April",
      "May", "June", "July", "August",
      "September", "October", "November", "December"
    ];

    for (var i = 0; i <= currentMonth; i++) {
      var option = $('<option>', {
        value: i + 1,
        text: months[i]
      });
      $('#monthFromSelect, #monthToSelect').append(option);

    }

    $('#monthToSelect').prop('selectedIndex', currentMonth);

    $('#monthFromSelect').prop('selectedIndex', currentMonth - 1);



  });
  $(document).ready(function() {
    ajaxstatismonth();
    $('#monthFromSelect, #monthToSelect').change(function() {

      ajaxstatismonth();
    });
    ajaxstatisyear();
    $('#yearFromSelect, #yearToSelect').change(function() {

      ajaxstatisyear();
    });

  });

  function ajaxstatismonth() {
    var fromMonth = $('#monthFromSelect').val();
    var toMonth = $('#monthToSelect').val();
    $.ajax({
      url: '../backend/Statistical.php',
      method: 'post',
      data: {
        key: 'monthfromto',
        from_month: fromMonth,
        to_month: toMonth
      },
      dataType: 'json',
      success: function(response) {
        $('#percent-month').empty();
        $('#monthfromspan').contents().last()[0].textContent = '';
        $('#monthtospan').contents().last()[0].textContent = '';


        $('#monthfromspan').append($('#monthFromSelect option:selected').text());
        $('#monthtospan').append($('#monthToSelect option:selected').text());
        statismonthchart(response.labels, response.monthform, response.monthto);
        if (response.percent >= 0) {
          var item = '<i class="fas fa-arrow-up"></i> $' + response.percent + '';
          $('#percent-month').removeClass('text-danger').addClass('text-success');

        } else {
          var item = '<i style="color: red" class="fas fa-arrow-down"></i> $' + response.percent + '';
          $('#percent-month').removeClass('text-success').addClass('text-danger');

        }
        $('#percent-month').append(item);
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  }

  function ajaxstatisyear() {
    var fromYear = $('#yearFromSelect').val();
    var toYear = $('#yearToSelect').val();
    $.ajax({
      url: '../backend/Statistical.php',
      method: 'post',
      data: {
        key: 'yearfromto',
        year_from: fromYear,
        year_to: toYear
      },
      dataType: 'json',
      success: function(response) {
        statisyearchart(response.yearfrom, response.yearto);

        $('#percent-year').empty();
        $('#yearfromspan').contents().last()[0].textContent = '';
        $('#yeartospan').contents().last()[0].textContent = '';

        $('#yearfromspan').append(fromYear);
        $('#yeartospan').append(toYear);
        if (response.percent >= 0) {
          var item = '<i class="fas fa-arrow-up"></i> $' + response.percent + '';
          $('#percent-month').removeClass('text-danger').addClass('text-success');

        } else {
          var item = '<i style="color: red" class="fas fa-arrow-down"></i> $' + response.percent + '';
          $('#percent-month').removeClass('text-success').addClass('text-danger');

        }
        $('#percent-year').append(item);
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  }


  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  function statismonthchart(labels, datafrom, datato) {

    var $visitorsChart = $('#visitors-chart')
    // eslint-disable-next-line no-unused-vars
    var visitorsChart = new Chart($visitorsChart, {
      data: {
        labels: labels,
        datasets: [{
            type: 'line',
            data: datafrom,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            pointBorderColor: '#007bff',
            pointBackgroundColor: '#007bff',
            fill: false
            // pointHoverBackgroundColor: '#007bff',
            // pointHoverBorderColor    : '#007bff'
          },
          {
            type: 'line',
            data: datato,
            backgroundColor: 'tansparent',
            borderColor: '#ced4da',
            pointBorderColor: '#ced4da',
            pointBackgroundColor: '#ced4da',
            fill: false
            // pointHoverBackgroundColor: '#ced4da',
            // pointHoverBorderColor    : '#ced4da'
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,
              suggestedMax: 200
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
  }

  function statisyearchart(yearfrom, yearto) {
    var $salesChart = $('#sales-chart')
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart($salesChart, {
      type: 'bar',
      data: {
        labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
        datasets: [{
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: yearfrom
          },
          {
            backgroundColor: '#ced4da',
            borderColor: '#ced4da',
            data: yearto
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,

              // Include a dollar sign in the ticks
              callback: function(value) {
                if (value >= 1000) {
                  value /= 1000
                  value += 'k'
                }

                return '$' + value
              }
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
  }
  $(document).ready(function() {
    showbestseller();
    $('#bestseller-select').change(function() {
      showbestseller();
    });
  });



  function showbestseller(){
    var categoryID = $('#bestseller-select').val();
    $.ajax({
      url: '../backend/Statistical.php',
      type: 'post',
      data:{
        key: 'bestseller',
        categoryID: categoryID
      },
      
      success:function(response){
        $("tbody").html(response);

      }
    });
  }

</script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard v3</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard v3</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo $countcate ?></h3>

            <p>Category</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="?page=Category/list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?php echo $countpro ?></h3>

            <p>Products</p>
          </div>
          <div class="icon">
            <i class="ion ion-pricetag "></i>
          </div>
          <a href="?page=Product/list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?php echo $countorder ?></h3>

            <p>Orders</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="?page=Order/delivered" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?php echo $countcus ?></h3>

            <p>Customer</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="?page=Customer_backup/list" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Sales - Month</h3>

            <!-- <a href="javascript:void(0);">View Report</a> -->
            <div class="card-tools">
              <label>From:</label>
              <select class="select-statis" id="monthFromSelect">

              </select>

              <label>To:</label>
              <select class="select-statis" id="monthToSelect">

              </select>
            </div>


          </div>
          <div class="card-body">
            <div class="d-flex">
              <p class="d-flex flex-column">
                <!-- <span class="text-bold text-lg">820</span> -->
                <span>Visitors Over Time</span>
              </p>
              <p class="ml-auto d-flex flex-column text-right">
                <span class="text-success" id="percent-month">

                </span>
                <!-- <span class="text-muted">Since last week</span> -->
              </p>
            </div>
            <!-- /.d-flex -->

            <div class="position-relative mb-4">
              <canvas id="visitors-chart" height="200"></canvas>
            </div>

            <div class="d-flex flex-row justify-content-end">
              <span class="mr-2" id="monthfromspan">
                <i class="fas fa-square text-primary"></i>
              </span>

              <span id="monthtospan">
                <i class="fas fa-square text-gray"></i>
              </span>
            </div>
          </div>
        </div>
        <!-- /.card -->

        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Best-seller Products</h3>

            <div class="card-tools">
              <label for="">Category</label>
              <select name="parentID" class="selectParent" id="bestseller-select">
                <option value="0">All</option>
                <?php
                recursiveCategory($categories, 0);
                ?>
              </select>
              <!-- <a href="#" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i>
              </a>
              <a href="#" class="btn btn-tool btn-sm">
                <i class="fas fa-bars"></i>
              </a> -->
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle" id="bestseller">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Category</th>
                  <th>Sold</th>
                  <th>Quantity</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-md-6 -->
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Sales - Year</h3>
            <div class="card-tools">
              <label>From: </label>
              <select class="select-statis" id="yearFromSelect">
                <?php foreach ($years as $year) : ?>
                  <option value="<?php echo $year ?>"><?php echo $year ?></option>
                <?php endforeach; ?>
                <option value="2023">2023</option>
              </select>

              <label>To: </label>
              <select class="select-statis" id="yearToSelect">
                <?php foreach ($years as $year) : ?>
                  <option value="<?php echo $year ?>"><?php echo $year ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex">
              <p class="d-flex flex-column">
                <!-- <span class="text-bold text-lg">$18,230.00</span> -->
                <span>Sales Over Time</span>
              </p>
              <p class="ml-auto d-flex flex-column text-right">
                <span class="text-success" id="percent-year">

                </span>
                <!-- <span class="text-muted">Since last month</span> -->
              </p>
            </div>
            <!-- /.d-flex -->

            <div class="position-relative mb-4">
              <canvas id="sales-chart" height="200"></canvas>
            </div>

            <div class="d-flex flex-row justify-content-end">
              <span class="mr-2" id="yearfromspan">
                <i class="fas fa-square text-primary"></i>
              </span>

              <span id="yeartospan">
                <i class="fas fa-square text-gray"></i>
              </span>
            </div>
          </div>
        </div>
        <!-- /.card -->

        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">Online Store Overview</h3>
            <div class="card-tools">
              <a href="#" class="btn btn-sm btn-tool">
                <i class="fas fa-download"></i>
              </a>
              <a href="#" class="btn btn-sm btn-tool">
                <i class="fas fa-bars"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
              <p class="text-success text-xl">
                <i class="ion ion-ios-refresh-empty"></i>
              </p>
              <p class="d-flex flex-column text-right">
                <span class="font-weight-bold">
                  <i class="ion ion-android-arrow-up text-success"></i> 12%
                </span>
                <span class="text-muted">CONVERSION RATE</span>
              </p>
            </div>
            <!-- /.d-flex -->
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
              <p class="text-warning text-xl">
                <i class="ion ion-ios-cart-outline"></i>
              </p>
              <p class="d-flex flex-column text-right">
                <span class="font-weight-bold">
                  <i class="ion ion-android-arrow-up text-warning"></i> 0.8%
                </span>
                <span class="text-muted">SALES RATE</span>
              </p>
            </div>
            <!-- /.d-flex -->
            <div class="d-flex justify-content-between align-items-center mb-0">
              <p class="text-danger text-xl">
                <i class="ion ion-ios-people-outline"></i>
              </p>
              <p class="d-flex flex-column text-right">
                <span class="font-weight-bold">
                  <i class="ion ion-android-arrow-down text-danger"></i> 1%
                </span>
                <span class="text-muted">REGISTRATION RATE</span>
              </p>
            </div>
            <!-- /.d-flex -->
          </div>
        </div>
      </div>
      <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>